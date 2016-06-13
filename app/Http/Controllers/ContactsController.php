<?php

namespace App\Http\Controllers;


use App\contact;
use App\Group;
use App\Tag;
use App\Event;
use App\Service;
use App\Training;
use App\Position;
use Auth;
use App\Http\Requests;
use App\Http\Requests\ContactRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
	public function __construct()
	{
		$this->middleware('manager', ['only' => 'create']);
	}

	public function index(){
		$contacts = contact::latest('fname')->get();
		
		return view('contacts.index', compact('contacts'));
	}
	public function show(contact $contact_show)
	{
        $events = Event::lists('name', 'id');
        $trainings = Training::lists('name', 'id');
        $groups = Group::lists('name', 'id');
        $serviceType = '';
        $trainingCat = '';
		return view('contacts.show', compact('contact_show', 'events', 'groups', 'trainings','serviceType', 'trainingCat'));
	}
	public function create()
	{
		$tags = Tag::lists('name', 'id');
        $leaders = contact::Onlyposition(0, 1)->get()->lists('full_name', 'id');
        $positions = Position::lists('title', 'id');
        $groups = Group::lists('name', 'id');

		return view('contacts.create', compact('tags', 'leaders', 'positions', 'groups'));
	}
	
	public function store(ContactRequest $request)
	{

		$this->createContact($request);

		return redirect('contacts');
	}
    public function edit(contact $contact)
    {
        $tags = Tag::lists('name', 'id');
        $groups = Group::lists('name', 'id');
        $leaders = contact::Onlyposition($contact->id, 1)->get()->lists('full_name', 'id');
        $positions = Position::lists('title', 'id');

        return view('contacts.edit', compact('contact', 'tags', 'leaders', 'positions', 'groups'));
    }
    public function update(contact $contact, ContactRequest $request)
    {
        //$contact = contact::findOrFail($id);
        $contact->update($request->all());

        $taglist = $request->input('tag_list');

        if(count($request->input('tag_list')) == 0) {
            $taglist = [];
        }

            $this->syncTags($contact, $taglist , $request->input('position_list'));


        return redirect('contacts');

    }

    private function syncTags(contact $contact, array $tags, array $positions)
    {

            $allTagIds = array();
            foreach ($tags as $tag) {
                if (substr($tag, 0, 4) == 'new:') {
                    $newTag = Tag::create(['name' => substr($tag, 4)]);
                    $allTagIds[] = $newTag->id;
                    continue;
                }
                $allTagIds[] = $tag;
            }
            $contact->tags()->sync($allTagIds);

        $allPositionIds = array();
        foreach ($positions as $position) {
            if (substr($position, 0, 4) == 'new:') {
                $newPosition = Tag::create(['name' => substr($position, 6)]);
                $allPositionIds[] = $newPosition->id;
                continue;
            }
            $allPositionIds[] = $position;
        }
        $contact->positions()->sync($allPositionIds);
    }
    private function createContact(ContactRequest $request)
    {
        $request->request->add(['church_id' => Auth::user()->church_id]);
        $contact = Auth::user()->contacts()->create($request->all());
        $taglist = $request->input('tag_list');

        if(count($request->input('tag_list')) == 0) {
            $taglist = [];
        }

        $this->syncTags($contact, $taglist, $request->input('position_list'));

        return $contact;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(contact $contact)
    {

        $contact->delete();
        return redirect()->route('contacts.index');
    }

    public function syncEvents(contact $contact, Request $request)
    {
        $contact->events()->sync([$request->input('event_id')=>['date'=>$request->input('event_date'), 'note'=>$request->input('event_text')]], false);
        return redirect()->back();
    }

    public function syncGroups(contact $contact, Request $request)
    {
        $contact->groups()->attach([$request->input('group_id')=>['date'=>$request->input('group_date'), 'note'=>$request->input('group_text')]]);
        return redirect()->back();
    }
    public function syncTrainings(contact $contact, Request $request)
    {
        $contact->trainings()->sync([$request->input('training_id')=>['date'=>$request->input('training_date'), 'note'=>$request->input('training_text')]], false);
        return redirect()->back();
    }
}
