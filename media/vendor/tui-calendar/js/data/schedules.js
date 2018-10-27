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
    this.isReadOnly = true;

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
            phone: ''
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

function generateRandomSchedule(calendar, renderStart, renderEnd) {
    var schedule = new ScheduleInfo();

    schedule.id = chance.guid();
    schedule.calendarId = calendar.id;

    schedule.title = 'ANurag';
    schedule.isReadOnly = false;

    schedule.isAllday  = false;
    // schedule.dueDateClass = 'morning';
    // schedule.start = '2018-10-27T17:30:00+09:00';
    // schedule.end = '2018-10-T17:31:00+09:00'
    generateTime(schedule, renderStart, renderEnd);

    schedule.isPrivate = false;
    schedule.location = 'patna';
    schedule.attendees ='anyone';
    schedule.recurrenceRule = chance.bool({likelihood: 20});

    schedule.color = calendar.color;
    schedule.bgColor = calendar.bgColor;
    schedule.dragBgColor = calendar.dragBgColor;
    schedule.borderColor = calendar.borderColor;

    if (schedule.category === 'milestone') {
        schedule.color = schedule.bgColor;
        schedule.bgColor = 'transparent';
        schedule.dragBgColor = 'transparent';
        schedule.borderColor = 'transparent';
    }

    schedule.raw.memo = chance.sentence();
    schedule.raw.creator.name = 'Anurag Kumar';
    schedule.raw.creator.avatar = 'Fuck';
    schedule.raw.creator.company = 'Joomla';
    schedule.raw.creator.email = 'anuragvns1111@gmail.com';
    schedule.raw.creator.phone = 'Joomla';

    ScheduleList.push(schedule);
}

function generateSchedule(viewName, renderStart, renderEnd) {
    ScheduleList = [];
    CalendarList.forEach(function(calendar) {
        var i = 0, length = 10;
        if (viewName === 'month') {
            length = 3;
        } else if (viewName === 'day') {
            length = 4;
        }
        for (; i < length; i += 1) {
            generateRandomSchedule(calendar, renderStart, renderEnd);
        }
    });
}
