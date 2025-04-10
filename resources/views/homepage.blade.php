@extends('layouts.default')
@section('content')
    <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark" style="padding-right: 10px;padding-left: 10px  ;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="img/logo.png" alt="Logo" width="30" class="d-inline-block align-text-top">
                HelpCenter ICT
            </a>
            <span class="navbar-text">
                Welcome, {{ $cn }}&nbsp&nbsp
            </span>
        </div>
        <form class="justify-content-end" method="post" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-danger" type="submit">Logout</button>
        </form>
    </nav>
    <div class="container">
        <div class="create-ticket-wrapper">
            <div class="create-ticket">
                <span> Are you having issues with your device?</span>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_ticket">Create
                    Ticket</button>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="issue-wrapper">
            <div class="issue">
                <div class="issue-title">
                    <h2>Support Ticket History</h2>
                    <div class="table-wrapper" id="tableWrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>attachments</th>
                                    <th>Assigned To</th>
                                    <th>status</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                @foreach ($tickets as $ticket)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($ticket->created_at)->diffForHumans() }}</td>
                                        <td data-bs-toggle="tooltip" data-bs-title="{{ $ticket->title }}">
                                            {{ $ticket->title }}</td>
                                        <td data-bs-toggle="tooltip" data-bs-title="{{ $ticket->description }}">
                                            {{ $ticket->description }}</td>
                                        <td>{{ $ticket->attachment ?? 'No attachment' }}</td>
                                        <td>{{ $ticket->assigned_to }}</td>
                                        <td><span class="{{ $ticket->status }}"></span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>









    <div class="container">
        <div class="faq-wrapper">
            <div class="faq">
                <div class="faq-title">
                    <h1>Frequently Asked Questions</h1>
                </div>
                <div class="accordion" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                1. Why is my device not connecting to the network?
                            </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                Make sure your Wi-Fi or Ethernet cable is properly connected. Try restarting
                                your router and the device. If the problem persists, check if other devices can connect
                                or
                                contact
                                support to verify if there's a network outage.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                2. What should I do if my hardware isn’t being detected?
                            </button>
                        </h2>
                        <div id="flush-collapseTwo" class="accordion-collapse collapse"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                Ensure all cables are securely connected and the hardware is powered on. For
                                USB or plug-in devices, try using a different port or restarting your computer. If it
                                still
                                doesn’t
                                work, it may require a driver update or further diagnosis.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseThree" aria-expanded="false"
                                aria-controls="flush-collapseThree">
                                3. My printer is connected but not printing. What can I do?
                            </button>
                        </h2>
                        <div id="flush-collapseThree" class="accordion-collapse collapse"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                First, check if the printer has paper and ink/toner. Make sure it’s set as the default
                                printer and
                                there are no errors showing. Restart both your printer and computer. If it’s still not
                                working, try
                                reinstalling the printer driver.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseFour" aria-expanded="false"
                                aria-controls="flush-collapseFour">
                                4. Why is my software crashing or not responding?
                            </button>
                        </h2>
                        <div id="flush-collapseFour" class="accordion-collapse collapse"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                This could be due to compatibility issues, missing updates, or corrupted files. Try
                                restarting your device, updating the software, or reinstalling it. If the problem
                                continues, check for known issues or contact support with error details.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="add_ticket" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" id="addForm" method="POST" action="{{ route('submit_ticket') }}">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        Create New Ticket
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Title</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder=""
                            name="title" />
                        <div class="form-text" id="basic-addon4">Example: Issue with network</div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="8" name="description"></textarea>
                        <div class="form-text" id="basic-addon4">Describe the issue, including symptoms, impact and
                            relevant information.</div>
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label"><span style="color: red;">*</span>Attachment<span
                                style="font-size: 12px;">(Optional)</span></label>
                        <input class="form-control" type="file" id="formFile" name="attachment">
                        <div class="form-text" id="basic-addon4">Example: Screenshow</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closeBtn">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
@endsection
