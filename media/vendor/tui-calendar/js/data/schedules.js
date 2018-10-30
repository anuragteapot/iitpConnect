'use strict';

/*eslint-disable*/

var ScheduleList = [];

var SCHEDULE_CATEGORY = [
    'milestone',
    'task'
];

function ScheduleInfo() {
    this.id = null;
    this.calendarId = null;

    this.title = null;
    this.isAllday = false;
    this.start = null;
    this.end = null;
    this.category = '';
    this.dueDateClass = '';

    this.color = null;
    this.bgColor = null;
    this.dragBgColor = null;
    this.borderColor = null;
    this.customStyle = '';

    this.isFocused = false;
    this.isPending = false;
    this.isVisible = true;
    this.isReadOnly = false;

    this.raw = {
        memo: '',
        hasToOrCc: false,
        hasRecurrenceRule: false,
        location: null,
        class: 'public', // or 'private'
        creator: {
            name: '',
            avatar: '',
            company: '',
            email: '',
            phone: '',
            username:'',
            uid:'',
            cabid:''
        }
    };
}


function generateTime(schedule, renderStart, renderEnd) {
    var baseDate = new Date(renderStart);
    var singleday = chance.bool({likelihood: 70});
    var startDate = moment(renderStart.getTime())
    var endDate = moment(renderEnd.getTime());
    var diffDate = endDate.diff(startDate, 'days');

    schedule.isAllday = chance.bool({likelihood: 30});
      if (schedule.isAllday) {
          schedule.category = 'allday';
      } else if (chance.bool({likelihood: 30})) {
        schedule.category = SCHEDULE_CATEGORY[chance.integer({min: 0, max: 1})];
        if (schedule.category === SCHEDULE_CATEGORY[1]) {
            schedule.dueDateClass = 'morning';
        }
    } else {
        schedule.category = 'time';
    }

    startDate.add(chance.integer({min: 0, max: diffDate}), 'days');
    startDate.hours(chance.integer({min: 0, max: 23}))
    startDate.minutes(chance.bool() ? 0 : 30);
    // schedule.start = startDate.toDate();

    schedule.start = '2018-10-28T04:30:00.000Z';
    schedule.end  = '2018-10-28T06:30:00.000Z';

    // console.log(schedule.start);
    // endDate = moment(startDate);
    // if (schedule.isAllday) {
    //     endDate.add(chance.integer({min: 0, max: 3}), 'days');
    // }
    //
    // schedule.end = endDate
    //     .add(chance.integer({min: 1, max: 4}), 'hour')
    //     .toDate();
    //   console.log(schedule.end);
}

function generateRandomSchedule(calendar) {
    var schedule = new ScheduleInfo();

    schedule.id = 1;
    schedule.calendarId = calendar.calendarid;

    schedule.title = calendar.title;
    schedule.isReadOnly = false;

    schedule.isAllday  = false;

    if (schedule.isAllday) {
        schedule.category = 'allday';
    }else {
      schedule.category = 'time';
    }

    schedule.start = calendar.startDate;
    schedule.end = calendar.endDate;

    schedule.isPrivate = false;
    schedule.location = calendar.location;
    schedule.attendees ='anyone';
    schedule.recurrenceRule = chance.bool({likelihood: 20});

    schedule.color = '#ffffff';
    schedule.bgColor = '#9e5fff';
    schedule.dragBgColor = '#9e5fff';
    schedule.borderColor = '#9e5fff';

    if (schedule.category === 'milestone') {
        schedule.color = schedule.bgColor;
        schedule.bgColor = 'transparent';
        schedule.dragBgColor = 'transparent';
        schedule.borderColor = 'transparent';
    }

    schedule.raw.memo = calendar.username;
    schedule.raw.creator.name = calendar.name;
    schedule.raw.creator.avatar = 'Check';
    schedule.raw.creator.company = 'Joomla';
    schedule.raw.creator.email = calendar.email;
    schedule.raw.creator.phone = calendar.phonenumber;
    schedule.raw.creator.username = calendar.username;
    schedule.raw.creator.uid = calendar.uid;
    schedule.raw.creator.cabid = calendar.cabid;

    ScheduleList.push(schedule);
}

function generateSchedule(viewName, renderStart, renderEnd)
{
  const location = window.location.href;
  const tok = document.getElementById('token');
  const baseUrl = location.substring(0, location.indexOf('/post'));
  const params = 'submit=' + '&tok=' + tok.value + '&task=CabController.get';

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
          console.log(responseData);
        }
        else if(responseData.response == 'success') {

          responseData.data.forEach(function(calendar) {
            generateRandomSchedule(calendar);
            console.log(calendar);
          });

        }
      }

      if(this.status == 400) {
        console.log('Server Error');
      }
    };

  xhttp.send(params);
}
