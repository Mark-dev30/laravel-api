<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Support\Facades\Auth;
//RICHIAMO IL MODEL
use App\Models\Project;
use App\Models\Type;
use App\Models\Technology;
use App\Models\Lead;
use App\Mail\ConfirmProject;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //ASSEGNO A $projects I RECORDS DELLA TABELLA. IN QUESTO CASO DIVENTA UN ARRAY
        //Proect::all() FA RIFERIMENTO AL MODEL Project, all() E' UNA FUNZIONE PREDEFINITA CHE RECUPERA TUTTI I RECORD PRESENTI NELLA TABELLA DEL DATABASE CORRISPONDENTE AL MODELLO.
        $projects = Project::all();

        //REINDIRIZZA ALLA PAGINA INDEX. VIENE PASSATO L'ARRAY $projects TRAMITE COMPACT
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //CREO UN ARRAY CON I TIPI.
        $types = Type::all();
        $technologies = Technology::all();
        //REINDIRIZZA ALLA PAGINA CREATE.
        return view('admin.projects.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        //INIZIALMENTE, VIENE VALIDATO IL FORM INVIATO DALL'UTENTE ATTRAVERSO LA CLASSE "StoreProjectRequest" CHE CONTROLLA CHE I DATI SIANO CORRETTI E COERENTI CON LE REGOLE DI VALIDAZIONE DEFINITE.
        $form = $request->validated();
        //VIENE GENERATO UNO "slug" UNIVOCO PER IL NUOVO PROGETTO UTILIZZANDO IL METODO STATICO "generateSlug()" DELLA CLASSE "PROJECT".
        $slug = Project::generateSlug($request->title, '-');

        //L'ARRAY ASSOCIATIVO "$form" CONTENENTE I DATI DEL FORM VIENE QUINDI MODIFICATO PER INCLUDERE LO "slug" GENERATO.
        $form['slug'] = $slug;



        $newProject = new Project();

        if ($request->hasFile('cover_image')) {
            $path = Storage::disk('public')->put('project_images', $request->cover_image);

            $form['cover_image'] = $path;
        }

        //UN NUOVO OGGETTO "project" VIENE CREATO E POPOLATO CON I DATI DEL FORM UTILIZZANDO IL METODO "FILL()" PER ASSEGNARE TUTTI I VALORI PASSATI DALL'ARRAY "$FORM".
        $newProject->fill($form);


        //IL NUOVO PROGETTO VIENE SALVATO NEL DATABASE CON IL METODO "save()"
        $newProject->save();

        if ($request->has('technologies')) {
            $newProject->technologies()->sync($request->technologies);
        }

        $newLead = new Lead();

        $newLead->title = $form['title'];
        $newLead->slug = $form['slug'];
        $newLead->description = $form['description'];


        $newLead->save();

        Mail::to('info@portfolio.com')->send(new ConfirmProject($newLead));

        //REINDIRIZZA ALLA PAGINA INDEX. LA FUNZIONE with PASSA ALLA PAGINA INDEX UN MESSAGGIO
        return redirect()->route('admin.projects.index')->with('message', 'PROJECT CREATED');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //REINDIRIZZA ALLA PAGINA show. VIENE PASSATO IL SINGOLO PROGETTO $project TRAMITE COMPACT
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        $technologies = Technology::all();
        //REINDIRIZZA ALLA PAGINA EDIT. VIENE PASSATO IL SINGOLO PROGETTO $project TRAMITE COMPACT
        return view('admin.projects.edit', compact('project', 'types', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {

        //INIZIALMENTE, VIENE VALIDATO IL FORM INVIATO DALL'UTENTE ATTRAVERSO LA CLASSE "UpdateProjectRequest" CHE CONTROLLA CHE I DATI SIANO CORRETTI E COERENTI CON LE REGOLE DI VALIDAZIONE DEFINITE.
        $form = $request->validated();

        //VIENE GENERATO UNO "slug" UNIVOCO PER IL PROGETTO UTILIZZANDO IL METODO STATICO "generateSlug()" DELLA CLASSE "PROJECT".
        $slug = Project::generateSlug($request->title, '-');

        //AGGIUNGE L'ATTRIBUTO "slug" AI DATI VALIDATI DELLA RICHIESTA, ASSEGNANDO IL VALORE GENERATO ALLO STEP PRECEDENTE.
        $form['slug'] = $slug;
        if ($request->hasFile('cover_image')) {
            Storage::delete($project->cover_image);
        }

        $path = Storage::disk('public')->put('project_images', $request->cover_image);

        $form['cover_image'] = $path;

        //LA FUNZIONE UTILIZZA IL METODO "update" DELL'OGGETTO "project" PER AGGIORNARE IL PROGETTO CON I DATI VALIDATI E LO SLUG APPENA GENERATO. QUESTO METODO PRENDE COME ARGOMENTO UN ARRAY DI DATI E LI UTILIZZA PER AGGIORNARE L'ISTANZA DEL MODELLO.
        $project->update($form);

        if ($request->has('technologies')) {
            $project->technologies()->sync($request->technologies);
        }

        //REINDIRIZZA ALLA PAGINA INDEX. LA FUNZIONE with PASSA ALLA PAGINA INDEX UN MESSAGGIO
        return redirect()->route('admin.projects.index')->with('message', 'MODIFIED PROJECT');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->technologies()->sync([]);
        //LA FUNZIONE "destroy" ELIMINA IL PROGETTO SPECIFICATO
        $project->delete();

        //REINDIRIZZA ALLA PAGINA INDEX. LA FUNZIONE with PASSA ALLA PAGINA INDEX UN MESSAGGIO
        return redirect()->route('admin.projects.index')->with('message', 'PROJECT CANCELLED');
    }
}
