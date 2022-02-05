<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\CreateEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Repositories\EventRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Response;

use App\Http\Resources\EventCollection;

class EventController extends AppBaseController
{
    private $eventRepository;

    public function __construct(EventRepository $eventRepo)
    {
        $this->eventRepository = $eventRepo;
    }

    public function index(Request $request)
    {
        return (new EventCollection($this->eventRepository->all()))
            ->response()
            ->setStatusCode(200);

        // $events = $this->eventRepository->all();
        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Ok',
        //     'data' => $events->toArray()
        // ], 200);
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(CreateEventRequest $request)
    {
        $input = $request->all();
        $event = $this->eventRepository->create($input);
        return redirect(route('events.index'));
    }

    public function show($id)
    {
        $event = $this->eventRepository->find($id);
        if (empty($event)) {
            return redirect(route('events.index'));
        }
        return view('events.show')->with('event', $event);
    }

    public function edit($id)
    {
        $event = $this->eventRepository->find($id);
        if (empty($event)) {
            return redirect(route('events.index'));
        }
        return view('events.edit')->with('event', $event);
    }

    public function update($id, UpdateEventRequest $request)
    {
        $event = $this->eventRepository->find($id);
        if (empty($event)) {
            return redirect(route('events.index'));
        }
        $event = $this->eventRepository->update($request->all(), $id);
        return redirect(route('events.index'));
    }

    public function destroy($id)
    {
        $event = $this->eventRepository->find($id);
        if (empty($event)) {
            return redirect(route('events.index'));
        }
        $this->eventRepository->delete($id);
        return redirect(route('events.index'));
    }
}
