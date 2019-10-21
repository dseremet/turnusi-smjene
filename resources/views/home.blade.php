@extends('layout.master')
@section('content')
    @if(!$public)
        <div class="row">
            <div class="col-lg-6">
                <a href="{{ route('smjena.postavke') }}" class="btn btn-default">Postavke smjena</a>
            </div>

            <div class="col-lg-6">
                <label for="pocetak" class="control-label">Link za javno dijeljenje</label>
                <input type="text" class="form-control" readonly="readonly" id="sharing_link"
                       value="{{ route('public.calendar', $user->md5_id()) }}">
                <small><a
                        href="{{ route('public.calendar', $user->md5_id()) }}">{{ route('public.calendar', $user->md5_id()) }}</a>
                </small>
                <small id="msg"></small>
            </div>

        </div>
        <div class="clearfix"></div>
    @endif
    <div id="calendar" class="calendar"></div>
@endsection
@section('js')
    <script>
        $(function () {
            $("#sharing_link").focus(function () {
                var $this = $(this);
                $this.select();

                // Work around Chrome's little problem
                $this.mouseup(function () {
                    // Prevent further mouseup intervention
                    $this.unbind("mouseup");
                    return false;
                });

                copyToClipboardMsg(document.getElementById("sharing_link"), "msg");
            });
            $("#calendar").fullCalendar({
                nowIndicator: true,
                views: {
                    agendaDay: {
                        titleFormat: "dddd DD.MMM Y"
                    },
                    agendaWeek: {
                        groupByDateAndResource: true,
                        columnFormat: "ddd D.M",
                    },
                    agendaSevenDays: {
                        type: 'agenda',
                        columnFormat: "ddd D.M",
                        duration: {days: 7},
                        groupByDateAndResource: true,
                        buttonText: 'Narednih 7 dana'
                    },
                },
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay,agendaSevenDays'
                },
                buttonText: {
                    today: 'danas',
                    month: 'Mjesečno',
                    week: 'Sedmično',
                    day: 'Dnevno'
                },
                dayClick: function (date, jsEvent, view, resource) {
                    if (view.name === "month") {
                        $('#calendar').fullCalendar('gotoDate', date);
                        $('#calendar').fullCalendar('changeView', 'agendaDay');
                    }
                },
                events:

// your event source
                    {
                        url: '{{ $public ? "/kalendar-api/".$mdId : "/smjene-api" }}',
                        type: 'POST',
                        data: {
                            '_token': '{{ csrf_token() }}'
                        },
                        error: function () {
                            alert('Desila se greska pri dobavljanju smjena!');
                        },
                    },

            });

            if ($("#sharing_link").length) {

                function copyToClipboardMsg(elem, msgElem) {
                    var succeed = copyToClipboard(elem);
                    var msg;
                    if (!succeed) {
                        msg = "Tekst ne moze biti direktno kopiran, probajte rucno."
                    } else {
                        msg = "Tekst je kopiran."
                    }
                    if (typeof msgElem === "string") {
                        msgElem = document.getElementById(msgElem);
                    }
                    msgElem.innerHTML = msg;
                    setTimeout(function () {
                        msgElem.innerHTML = "";
                    }, 2000);
                }

                function copyToClipboard(elem) {
                    // create hidden text element, if it doesn't already exist
                    var targetId = "_hiddenCopyText_";
                    var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
                    var origSelectionStart, origSelectionEnd;
                    if (isInput) {
                        // can just use the original source element for the selection and copy
                        target = elem;
                        origSelectionStart = elem.selectionStart;
                        origSelectionEnd = elem.selectionEnd;
                    } else {
                        // must use a temporary form element for the selection and copy
                        target = document.getElementById(targetId);
                        if (!target) {
                            var target = document.createElement("textarea");
                            target.style.position = "absolute";
                            target.style.left = "-9999px";
                            target.style.top = "0";
                            target.id = targetId;
                            document.body.appendChild(target);
                        }
                        target.textContent = elem.textContent;
                    }
                    // select the content
                    var currentFocus = document.activeElement;
                    target.focus();
                    target.setSelectionRange(0, target.value.length);

                    // copy the selection
                    var succeed;
                    try {
                        succeed = document.execCommand("copy");
                    } catch (e) {
                        succeed = false;
                    }
                    // restore original focus
                    if (currentFocus && typeof currentFocus.focus === "function") {
                        currentFocus.focus();
                    }

                    if (isInput) {
                        // restore prior selection
                        elem.setSelectionRange(origSelectionStart, origSelectionEnd);
                    } else {
                        // clear temporary content
                        target.textContent = "";
                    }
                    return succeed;
                }
            }
        })
    </script>
@endsection
