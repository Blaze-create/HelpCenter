@extends('layouts.default')
@section('content')
    <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="img/logo.png" alt="Logo" width="30" class="d-inline-block align-text-top">
                HelpCenter ICT
            </a>
            <span class="navbar-text">
                Welcome, Castel Charles Nicolas
            </span>
        </div>
    </nav>

    <div class="container">
        <div class="create-ticket-wrapper">
            <div class="create-ticket">
                <span> Are we having issues with your device?</span>
                <button type="button" class="btn btn-primary">Create Ticket</button>
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
                                <tr>
                                    <td>2 day ago</td>
                                    <td>Issue with Network</td>
                                    <td data-bs-toggle="tooltip"
                                        data-bs-title="The computer crashes randomly during usage. When the crash occurs, the screen goes black, and the system completely freezes. I am unable to use the mouse or keyboard, and the computer doesn't respond to any input. I have to hold down the power button for 10 seconds to force a shutdown and then restart the computer. Upon restarting, I get the error message: Your PC ran into a problem and needs to restart. We’re just collecting some error info, and then we’ll restart for you Lorem, ipsum dolor sit amet consectetur adipisicing elit. Culpa,
                                    debitis?
                                    Aliquid perferendis labore sapiente officiis ipsam placeat officia autem
                                    repellat.">
                                        The computer crashes randomly during usage. When the crash occurs,
                                        the screen goes black, and the system completely freezes. I am unable to use the
                                        mouse or keyboard, and the computer doesn't respond to any input. I have to hold
                                        down the power button for 10 seconds to force a shutdown and then restart the
                                        computer. Upon restarting, I get the error message: Your PC ran into a problem
                                        and needs to restart. We’re just collecting some error info, and then we’ll
                                        restart for you Lorem, ipsum dolor sit amet consectetur adipisicing elit. Culpa,
                                        debitis?
                                        Aliquid perferendis labore sapiente officiis ipsam placeat officia autem
                                        repellat</td>
                                    <td>2 photo</td>
                                    <td>Baptise Luc Goelson</td>
                                    <td><span class="open"></span></td>
                                </tr>
                                <tr>
                                    <td>2 Months ago</td>
                                    <td>Issue with Network</td>
                                    <td data-bs-toggle="tooltip"
                                        data-bs-title="The internet connection drops intermittently. When the connection is lost, all online services stop working, and I cannot access any websites or services. Sometimes, the connection automatically reconnects, but other times, I have to manually disable and re-enable the network adapter. The issue happens randomly and can last anywhere from a few seconds to several minutes. I have checked the router and modem, and they seem to be working fine. It happens with both wired and wireless connections.">
                                        The internet connection drops intermittently. When the connection is lost, all
                                        online services stop working, and I cannot access any websites or services.
                                        Sometimes, the connection automatically reconnects, but other times, I have to
                                        manually disable and re-enable the network adapter. The issue happens randomly
                                        and can last anywhere from a few seconds to several minutes. I have checked the
                                        router and modem, and they seem to be working fine. It happens with both wired
                                        and wireless connections.</td>
                                    <td>1 photo</td>
                                    <td>Marie Dupont</td>
                                    <td><span class="inprogress"></span></td>
                                </tr>
                                <tr>
                                    <td>2 years ago</td>
                                    <td>Printer Malfunction</td>
                                    <td data-bs-toggle="tooltip"
                                        data-bs-title="The printer is not responding when I try to print documents. It shows as 'Offline' on my computer, even though it is connected via USB. I have tried restarting both the printer and the computer, but the issue persists. The printer is visible on the network, but when I try to print, nothing happens. Sometimes, the printer display shows an 'Error 404' message, but I'm not sure what that means. The printer was working fine last week.">
                                        The printer is not responding when I try to print documents. It shows as
                                        'Offline' on my computer, even though it is connected via USB. I have tried
                                        restarting both the printer and the computer, but the issue persists. The
                                        printer is visible on the network, but when I try to print, nothing happens.
                                        Sometimes, the printer display shows an 'Error 404' message, but I'm not sure
                                        what that means. The printer was working fine last week.</td>
                                    <td>2 photos</td>
                                    <td>John Smith</td>
                                    <td><span class="resolve"></span></td>
                                </tr>
                                <tr>
                                    <td>1 year ago</td>
                                    <td>Network Connectivity Issue</td>
                                    <td data-bs-toggle="tooltip"
                                        data-bs-title="The internet connection is constantly dropping, and the Wi-Fi signal is very weak. I've tried resetting the router and moving closer to it, but the issue continues. Other devices in the house seem to have no problem connecting, but my laptop keeps disconnecting. I also tried updating the network driver, but the issue persists.">
                                        The internet connection is constantly dropping, and the Wi-Fi signal is very weak.
                                        I've tried resetting the router and moving closer to it, but the issue continues.
                                        Other devices in the house seem to have no problem connecting, but my laptop keeps
                                        disconnecting. I also tried updating the network driver, but the issue persists.
                                    </td>
                                    <td>1 photo</td>
                                    <td>Jane Doe</td>
                                    <td><span class="closed"></span></td>
                                </tr>

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




    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
@endsection
