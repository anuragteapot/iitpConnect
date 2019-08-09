'use strict';

/* eslint-disable require-jsdoc */
/* eslint-env jquery */
/* global moment, tui, chance */
/* global findCalendar, CalendarList, ScheduleList, generateSchedule */

(function(window, Calendar) {
    var cal, resizeThrottled;
    var useCreationPopup = true;

    const uid = document.getElementById('uid');

    if(uid.value == '')
    {
      useCreationPopup = false;
    }

    var useDetailPopup = true;
    var datePicker, selectedCalendar;
    var tempcabid,tempuid;

    cal = new Calendar('#calendar', {
        defaultView: 'month',
        useCreationPopup: useCreationPopup,
        useDetailPopup: useDetailPopup,
        calendars: CalendarList,
        template: {
            milestone: function(model) {
                return '<span class="calendar-font-icon ic-milestone-b"></span> <span style="background-color: ' + model.bgColor + '">' + model.title + '</span>';
            },
            allday: function(schedule) {
                return getTimeTemplate(schedule, true);
            },
            time: function(schedule) {
                return getTimeTemplate(schedule, false);
            }
        }
    });

    // event handlers
    cal.on({
        'clickMore': function(e) {
            console.log('clickMore', e);
        },
        'clickSchedule': function(e) {

          const name = document.getElementById('name');
          const username = document.getElementById('username');
          const email = document.getElementById('email');
          const phoneNum = document.getElementById('phoneNum');
          const address = document.getElementById('address');
          const institute = document.getElementById('institute');

          // console.log(e);
          name.innerHTML = e.schedule.raw.name;
          username.innerHTML = e.schedule.raw.username;
          email.innerHTML = e.schedule.raw.email;
          phoneNum.innerHTML = e.schedule.raw.phone;
          address.innerHTML = e.schedule.raw.address;
          institute.innerHTML = e.schedule.raw.institute;

          tempuid  = e.schedule.raw.uid;
          tempcabid = e.schedule.raw.cabid;

        },
        'clickDayname': function(date) {
            console.log('clickDayname', date);
        },
        'beforeCreateSchedule': function(e) {
            iitpConnect.startLoader();
            const tok = document.getElementById('token');
            const uid = document.getElementById('uid');

            if(uid.value == '')
            {
              iitpConnect.renderMessage('Login to add your schedules.', 'error', 5000);
              return 0;
            }

            if(uid.value == '' && useCreationPopup)
            {
              iitpConnect.renderMessage('Error on processing request.', 'error', 5000);
              return 0;
            }

            var date = new Date(e.end._date);
            var dd = date.getDate();
            var mm = date.getMonth();
            var yy = date.getFullYear();

            var fullDate = yy +'/'+ mm +'/'+ dd;

            const location = window.location.href;
            const baseUrl = location.substring(0, location.indexOf('/post'));
            const params = 'submit=' + '&tok=' + tok.value + '&task=CabController.add' +'&calendarId=' + e.calendarId + '&isAllDay=' + e.isAllDay + '&state=' + e.state
              + '&useCreationPopup=' + e.useCreationPopup + '&title=' + e.title + '&rawClass=' + e.raw.class + '&end=' + JSON.stringify(e.end) + '&start=' + JSON.stringify(e.start) + '&uid=' + uid.value
              + '&location=' + e.location + '&fullDate=' + fullDate;


            const xhttp = new XMLHttpRequest();
            const url = baseUrl + '/index.php';
            const method = 'POST';

            xhttp.open(method, url, true);

            //Send the proper header information along with the request
              xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
              xhttp.setRequestHeader('CSRFToken', tok.value);
              xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

              xhttp.onreadystatechange = function() {
                if(this.readyState == 4 && this.status == 200) {
                  // console.log(xhttp.responseText);
                  const responseData = JSON.parse(xhttp.responseText)

                  if(responseData.response == 'error')
                  {
                    iitpConnect.stopLoader();
                    iitpConnect.renderMessage(responseData.text, responseData.response, 5000);
                    console.log(responseData);
                  }
                  else if(responseData.response == 'success') {
                    iitpConnect.renderMessage(responseData.text, responseData.response, 5000);

                    e.raw.uid = responseData.data[0].id;
                    e.raw.name = responseData.data[0].name;
                    e.raw.username = responseData.data[0].username;
                    e.raw.phone  = responseData.data[0].phonenumber;
                    e.raw.email = responseData.data[0].email;
                    e.raw.address = responseData.data[0].address;
                    e.raw.institute = responseData.data[0].institute;
                    e.raw.cabid = responseData.cabid.id;
                    iitpConnect.stopLoader();
                    saveNewSchedule(e);
                  }
                }

                if(this.status == 400) {
                  iitpConnect.stopLoader();
                  console.log('Server Error');
                }
              };

            xhttp.send(params);
        },
        'beforeUpdateSchedule': function(e) {
            console.log('beforeUpdateSchedule', e);
            e.schedule.start = e.start;
            e.schedule.end = e.end;

            const tok = document.getElementById('token');
            const uid = document.getElementById('uid');

            tempuid = tempuid || e.schedule.raw.uid;
            tempcabid = tempcabid || e.schedule.raw.cabid;

            if(uid.value == '' && uid.value == tempuid)
            {
              iitpConnect.renderMessage('Error on processing request.', 'error', 5000);
              return 0;
            }

            const location = window.location.href;
            const baseUrl = location.substring(0, location.indexOf('/post'));
            const params = 'submit=' + '&tok=' + tok.value + '&task=CabController.update' +'&calendarId=' + e.schedule.calendarId + '&isAllDay=' + e.schedule.isAllDay + '&state=' + e.schedule.state
              + '&useCreationPopup=' + e.useCreationPopup + '&title=' + e.schedule.title + '&rawClass=' + e.schedule.raw.class + '&end=' + JSON.stringify(e.end) + '&start=' + JSON.stringify(e.start) + '&uid=' + uid.value
              + '&location=' + e.schedule.location + '&cabid=' + tempcabid;

            const xhttp = new XMLHttpRequest();
            const url = baseUrl + '/index.php';
            const method = 'POST';

            xhttp.open(method, url, true);

            //Send the proper header information along with the request
              xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
              xhttp.setRequestHeader('CSRFToken', tok.value);
              xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

              xhttp.onreadystatechange = function() {
                if(this.readyState == 4 && this.status == 200) {
                  const responseData = JSON.parse(xhttp.responseText)

                  if(responseData.response == 'error')
                  {
                    iitpConnect.renderMessage(responseData.text, responseData.response, 5000);
                    console.log(responseData);
                  }
                  else if(responseData.response == 'success') {
                    iitpConnect.renderMessage(responseData.text, responseData.response, 5000);
                    cal.updateSchedule(e.schedule.id, e.schedule.calendarId, e.schedule);
                  }
                }

                if(this.status == 400) {
                  console.log('Server Error');
                }
              };

            xhttp.send(params);

            tempuid = '';
            tempcabid = '';
        },
        'beforeDeleteSchedule': function(e) {
            const tok = document.getElementById('token');
            const uid = document.getElementById('uid');

            if(uid.value == '' || uid.value != e.schedule.raw.uid)
            {
              iitpConnect.renderMessage('Error on processing request.', 'error', 5000);
              return 0;
            }
            else {


            const location = window.location.href;
            const baseUrl = location.substring(0, location.indexOf('/post'));
            const params = 'submit=' + '&tok=' + tok.value + '&task=CabController.delete' +'&cabid=' + e.schedule.raw.cabid + '&uid=' + e.schedule.raw.uid;

            const xhttp = new XMLHttpRequest();
            const url = baseUrl + '/index.php';
            const method = 'POST';

            xhttp.open(method, url, true);

            //Send the proper header information along with the request
              xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
              xhttp.setRequestHeader('CSRFToken', tok.value);
              xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

              xhttp.onreadystatechange = function() {
                if(this.readyState == 4 && this.status == 200) {
                  const responseData = JSON.parse(xhttp.responseText)

                  if(responseData.response == 'error')
                  {
                    iitpConnect.renderMessage(responseData.text, responseData.response, 5000);
                    console.log(responseData);
                  }
                  else if(responseData.response == 'success') {
                    iitpConnect.renderMessage(responseData.text, responseData.response, 5000);
                    cal.deleteSchedule(e.schedule.id, e.schedule.calendarId);
                  }
                }

                if(this.status == 400) {
                  console.log('Server Error');
                }
              };

            xhttp.send(params);
          }
        },
        'afterRenderSchedule': function(e) {
            var schedule = e.schedule;
            var element = cal.getElement(schedule.id, schedule.calendarId);
            // console.log('afte  rRenderSchedule', element);
        },
        'clickTimezonesCollapseBtn': function(timezonesCollapsed) {
            console.log('timezonesCollapsed', timezonesCollapsed);

            if (timezonesCollapsed) {
                cal.setTheme({
                    'week.daygridLeft.width': '77px',
                    'week.timegridLeft.width': '77px'
                });
            } else {
                cal.setTheme({
                    'week.daygridLeft.width': '60px',
                    'week.timegridLeft.width': '60px'
                });
            }

            return true;
        }
    });

    /**
     * Get time template for time and all-day
     * @param {Schedule} schedule - schedule
     * @param {boolean} isAllDay - isAllDay or hasMultiDates
     * @returns {string}
     */
    function getTimeTemplate(schedule, isAllDay) {
        var html = [];
        var start = moment(schedule.start.toUTCString());
        if (!isAllDay) {
            html.push('<strong>' + start.format('HH:mm') + '</strong> ');
        }
        if (schedule.isPrivate) {
            html.push('<span class="calendar-font-icon ic-lock-b"></span>');
            html.push(' Private');
        } else {
            if (schedule.isReadOnly) {
                html.push('<span class="calendar-font-icon ic-readonly-b"></span>');
            } else if (schedule.recurrenceRule) {
                html.push('<span class="calendar-font-icon ic-repeat-b"></span>');
            } else if (schedule.attendees.length) {
                html.push('<span class="calendar-font-icon ic-user-b"></span>');
            } else if (schedule.location) {
                html.push('<span class="calendar-font-icon ic-location-b"></span>');
            }
            html.push(' ' + schedule.title);
        }

        return html.join('');
    }

    /**
     * A listener for click the menu
     * @param {Event} e - click event
     */
    function onClickMenu(e) {
        var target = $(e.target).closest('a[role="menuitem"]')[0];
        var action = getDataAction(target);
        var options = cal.getOptions();
        var viewName = '';

        console.log(target);
        console.log(action);
        switch (action) {
            case 'toggle-daily':
                viewName = 'day';
                break;
            case 'toggle-weekly':
                viewName = 'week';
                break;
            case 'toggle-monthly':
                options.month.visibleWeeksCount = 0;
                viewName = 'month';
                break;
            case 'toggle-weeks2':
                options.month.visibleWeeksCount = 2;
                viewName = 'month';
                break;
            case 'toggle-weeks3':
                options.month.visibleWeeksCount = 3;
                viewName = 'month';
                break;
            case 'toggle-narrow-weekend':
                options.month.narrowWeekend = !options.month.narrowWeekend;
                options.week.narrowWeekend = !options.week.narrowWeekend;
                viewName = cal.getViewName();

                target.querySelector('input').checked = options.month.narrowWeekend;
                break;
            case 'toggle-start-day-1':
                options.month.startDayOfWeek = options.month.startDayOfWeek ? 0 : 1;
                options.week.startDayOfWeek = options.week.startDayOfWeek ? 0 : 1;
                viewName = cal.getViewName();

                target.querySelector('input').checked = options.month.startDayOfWeek;
                break;
            case 'toggle-workweek':
                options.month.workweek = !options.month.workweek;
                options.week.workweek = !options.week.workweek;
                viewName = cal.getViewName();

                target.querySelector('input').checked = !options.month.workweek;
                break;
            default:
                break;
        }

        cal.setOptions(options, true);
        cal.changeView(viewName, true);

        setDropdownCalendarType();
        setRenderRangeText();
        setSchedules();
    }

    function onClickNavi(e) {
        var action = getDataAction(e.target);

        switch (action) {
            case 'move-prev':
                cal.prev();
                break;
            case 'move-next':
                cal.next();
                break;
            case 'move-today':
                cal.today();
                break;
            default:
                return;
        }

        setRenderRangeText();
        setSchedules();
    }

    function onNewSchedule() {
        var title = $('#new-schedule-title').val();
        var location = $('#new-schedule-location').val();
        var isAllDay = document.getElementById('new-schedule-allday').checked;
        var start = datePicker.getStartDate();
        var end = datePicker.getEndDate();
        var calendar = selectedCalendar ? selectedCalendar : CalendarList[0];

        if (!title) {
            return;
        }

        cal.createSchedules([{
            id: String(chance.guid()),
            calendarId: calendar.id,
            title: title,
            isAllDay: isAllDay,
            start: start,
            end: end,
            category: isAllDay ? 'allday' : 'time',
            dueDateClass: '',
            color: calendar.color,
            bgColor: calendar.bgColor,
            dragBgColor: calendar.bgColor,
            borderColor: calendar.borderColor,
            raw: {
                location: location
            },
            state: 'Student'
        }]);

        $('#modal-new-schedule').modal('hide');
    }

    function onChangeNewScheduleCalendar(e) {
        var target = $(e.target).closest('a[role="menuitem"]')[0];
        var calendarId = getDataAction(target);
        changeNewScheduleCalendar(calendarId);
    }

    function changeNewScheduleCalendar(calendarId) {
        var calendarNameElement = document.getElementById('calendarName');
        var calendar = findCalendar(calendarId);
        var html = [];

        html.push('<span class="calendar-bar" style="background-color: ' + calendar.bgColor + '; border-color:' + calendar.borderColor + ';"></span>');
        html.push('<span class="calendar-name">' + calendar.name + '</span>');

        calendarNameElement.innerHTML = html.join('');

        selectedCalendar = calendar;
    }

    function createNewSchedule(event) {
        var start = event.start ? new Date(event.start.getTime()) : new Date();
        var end = event.end ? new Date(event.end.getTime()) : moment().add(1, 'hours').toDate();

        if (useCreationPopup) {
            cal.openCreationPopup({
                start: start,
                end: end
            });
        }
    }
    function saveNewSchedule(scheduleData) {
        var calendar = scheduleData.calendar || findCalendar(scheduleData.calendarId);
        var schedule = {
            id: String(chance.guid()),
            title: scheduleData.title,
            isAllDay: scheduleData.isAllDay,
            start: scheduleData.start,
            end: scheduleData.end,
            category: scheduleData.isAllDay ? 'allday' : 'time',
            dueDateClass: '',
            color: calendar.color,
            bgColor: calendar.bgColor,
            dragBgColor: calendar.bgColor,
            borderColor: calendar.borderColor,
            location: scheduleData.location,
            raw: {
                class: scheduleData.raw['class'],
                username: scheduleData.raw['username'],
                name: scheduleData.raw['name'],
                phone: scheduleData.raw['phone'],
                email: scheduleData.raw['email'],
                address: scheduleData.raw['address'],
                memo: scheduleData.raw['memo'],
                uid: scheduleData.raw['uid'],
                cabid: scheduleData.raw['cabid'],
                institute: scheduleData.raw['institute'],
            },
            state: scheduleData.state
        };
        if (calendar) {
            schedule.calendarId = calendar.id;
            schedule.color = calendar.color;
            schedule.bgColor = calendar.bgColor;
            schedule.borderColor = calendar.borderColor;
        }

        cal.createSchedules([schedule]);

        refreshScheduleVisibility();
    }

    function onChangeCalendars(e) {
        var calendarId = e.target.value;
        var checked = e.target.checked;
        var viewAll = document.querySelector('.lnb-calendars-item input');
        var calendarElements = Array.prototype.slice.call(document.querySelectorAll('#calendarList input'));
        var allCheckedCalendars = true;

        if (calendarId === 'all') {
            allCheckedCalendars = checked;

            calendarElements.forEach(function(input) {
                var span = input.parentNode;
                input.checked = checked;
                span.style.backgroundColor = checked ? span.style.borderColor : 'transparent';
            });

            CalendarList.forEach(function(calendar) {
                calendar.checked = checked;
            });
        } else {
            findCalendar(calendarId).checked = checked;

            allCheckedCalendars = calendarElements.every(function(input) {
                return input.checked;
            });

            if (allCheckedCalendars) {
                viewAll.checked = true;
            } else {
                viewAll.checked = false;
            }
        }

        refreshScheduleVisibility();
    }

    function refreshScheduleVisibility() {
        var calendarElements = Array.prototype.slice.call(document.querySelectorAll('#calendarList input'));

        CalendarList.forEach(function(calendar) {
            cal.toggleSchedules(calendar.id, !calendar.checked, false);
        });

        cal.render(true);

        calendarElements.forEach(function(input) {
            var span = input.nextElementSibling;
            span.style.backgroundColor = input.checked ? span.style.borderColor : 'transparent';
        });
    }

    function setDropdownCalendarType() {
        var calendarTypeName = document.getElementById('calendarTypeName');
        var calendarTypeIcon = document.getElementById('calendarTypeIcon');
        var options = cal.getOptions();
        var type = cal.getViewName();
        var iconClassName;

        if (type === 'day') {
            type = 'Daily';
            iconClassName = 'calendar-icon ic_view_day';
        } else if (type === 'week') {
            type = 'Weekly';
            iconClassName = 'calendar-icon ic_view_week';
        } else if (options.month.visibleWeeksCount === 2) {
            type = '2 weeks';
            iconClassName = 'calendar-icon ic_view_week';
        } else if (options.month.visibleWeeksCount === 3) {
            type = '3 weeks';
            iconClassName = 'calendar-icon ic_view_week';
        } else {
            type = 'Monthly';
            iconClassName = 'calendar-icon ic_view_month';
        }

        calendarTypeName.innerHTML = type;
        calendarTypeIcon.className = iconClassName;
    }

    function setRenderRangeText() {
        var renderRange = document.getElementById('renderRange');
        var options = cal.getOptions();
        var viewName = cal.getViewName();
        var html = [];
        if (viewName === 'day') {
            html.push(moment(cal.getDate().getTime()).format('YYYY.MM.DD'));
        } else if (viewName === 'month' &&
            (!options.month.visibleWeeksCount || options.month.visibleWeeksCount > 4)) {
            html.push(moment(cal.getDate().getTime()).format('YYYY.MM'));
        } else {
            html.push(moment(cal.getDateRangeStart().getTime()).format('YYYY.MM.DD'));
            html.push(' ~ ');
            html.push(moment(cal.getDateRangeEnd().getTime()).format(' MM.DD'));
        }
        renderRange.innerHTML = html.join('');
    }


    function setSchedules() {
        cal.clear();

        var sec = [];

        const location = window.location.href;
        const tok = document.getElementById('token');
        const baseUrl = location.substring(0, location.indexOf('/post'));
        const uid = document.getElementById('uid');
        const params = 'submit=' + '&tok=' + tok.value + '&task=CabController.get';

        const xhttp = new XMLHttpRequest();
        const url = baseUrl + '/index.php';
        const method = 'POST';

        xhttp.open(method, url, true);

        xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhttp.setRequestHeader('CSRFToken', tok.value);
        xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhttp.onreadystatechange = function() {
          iitpConnect.startLoader();
            if(this.readyState == 4 && this.status == 200) {
              const responseData = JSON.parse(xhttp.responseText)

              if(responseData.response == 'error')
              {
                console.log(responseData);
                iitpConnect.stopLoader();
              }
              else if(responseData.response == 'success') {
                var cdata = responseData.data;
                responseData.data.forEach(function(cdata) {
                  var calendar = findCalendar(cdata.calendarid);

                  var st  = JSON.parse(cdata.startDate);
                  var en = JSON.parse(cdata.endDate);

                  var schedule = {
                    id: String(chance.guid()),
                    title: cdata.title,
                    isAllday: cdata.isAllday,
                    start: st._date,
                    end: en._date,
                    cabid: cdata.cabid,
                    category: 'time',
                    dueDateClass: '',
                    color: calendar.color,
                    bgColor: calendar.bgColor,
                    dragBgColor: calendar.bgColor,
                    borderColor: calendar.borderColor,
                    location: cdata.location,
                    isFocused: false,
                    isPending: false,
                    isVisible: true,
                    calendarId: cdata.calendarid,
                      raw: {
                        name: cdata.name,
                        username: cdata.username,
                        uid: cdata.uid,
                        cabid: cdata.cabid,
                        email: cdata.email,
                        phone: cdata.phonenumber,
                        class: cdata.rawClass,
                        address:  cdata.address,
                        institute: cdata.institute,
                        state: cdata.state,
                      },
                      state: cdata.state,
                    };

                  if(uid.value == cdata.uid) {
                    schedule.isReadOnly = false;
                  }
                  else {
                    schedule.isReadOnly = true;
                  }

                  if (calendar) {
                      schedule.calendarId = calendar.id;
                      schedule.color = calendar.color;
                      schedule.bgColor = calendar.bgColor;
                      schedule.borderColor = calendar.borderColor;
                  }

                  cal.createSchedules([schedule]);
                });

                iitpConnect.stopLoader();
              }
            }
            if(this.status == 400 || this.status == 500) {
              iitpConnect.stopLoader();
              console.log('Server Error');
            }
          };

        xhttp.send(params);
        refreshScheduleVisibility();
    }

    function setEventListener() {
        $('#menu-navi').on('click', onClickNavi);
        $('.dropdown-menu a[role="menuitem"]').on('click', onClickMenu);
        $('#lnb-calendars').on('change', onChangeCalendars);

        $('#btn-save-schedule').on('click', onNewSchedule);
        $('#btn-new-schedule').on('click', createNewSchedule);

        $('#dropdownMenu-calendars-list').on('click', onChangeNewScheduleCalendar);

        window.addEventListener('resize', resizeThrottled);
    }

    function getDataAction(target) {
        return target.dataset ? target.dataset.action : target.getAttribute('data-action');
    }

    resizeThrottled = tui.util.throttle(function() {
        cal.render();
    }, 50);

    window.cal = cal;

    setDropdownCalendarType();
    setRenderRangeText();
    setSchedules();
    setEventListener();
})(window, tui.Calendar);

// set calendars
(function() {
    var calendarList = document.getElementById('calendarList');
    var html = [];
    CalendarList.forEach(function(calendar) {
        html.push('<div class="lnb-calendars-item"><label>' +
            '<input type="checkbox" class="tui-full-calendar-checkbox-round" value="' + calendar.id + '" checked>' +
            '<span style="border-color: ' + calendar.borderColor + '; background-color: ' + calendar.borderColor + ';"></span>' +
            '<span>' + calendar.name + '</span>' +
            '</label></div>'
        );
    });
    calendarList.innerHTML = html.join('\n');
})();
