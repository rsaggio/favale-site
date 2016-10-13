jQuery(document).ready(function ($) {

    var CalendarEvent = function (time, title) {
        this.time = time;
        this.title = title;
    };

    var allEvents = {
        '2014-04-01': [
            new CalendarEvent('Chest, Triceps and Abs')
        ],
        '2014-04-03': [
            new CalendarEvent('Shoulders, Legs and Calves')
        ],
        '2014-04-05': [
            new CalendarEvent('Back, Traps and Biceps')
        ],
        '2014-04-06': [
            new CalendarEvent('Cardio')
        ],
        '2014-04-09': [
            new CalendarEvent('Shoulders, Legs, Calves, Chest, Triceps and Abs'),
            new CalendarEvent('Calves, Chest, Triceps and Abs')
        ],
        '2014-04-18': [
            new CalendarEvent('Chest, Triceps and Abs')
        ],
        '2014-04-23': [
            new CalendarEvent('Back, Traps and Biceps')
        ],
        '2014-04-26': [
            new CalendarEvent('Shoulders, Legs and Calves')
        ],
        '2014-04-27': [
            new CalendarEvent('Back, Traps and Biceps')
        ],
        '2014-04-30': [
            new CalendarEvent('Chest, Triceps and Abs')
        ],
        '2014-05-02': [
            new CalendarEvent('Chest, Triceps and Abs')
        ],
        '2014-05-06': [
            new CalendarEvent('Shoulders, Legs and Calves')
        ],
        '2014-05-08': [
            new CalendarEvent('Back, Traps and Biceps')
        ],
        '2014-05-12': [
            new CalendarEvent('Cardio')
        ],
        '2014-05-13': [
            new CalendarEvent('Shoulders, Legs, Calves, Chest, Triceps and Abs'),
            new CalendarEvent('Calves, Chest, Triceps and Abs')
        ],
        '2014-05-16': [
            new CalendarEvent('Chest, Triceps and Abs')
        ],
        '2014-05-18': [
            new CalendarEvent('Back, Traps and Biceps')
        ],
        '2014-05-24': [
            new CalendarEvent('Shoulders, Legs and Calves')
        ],
        '2014-05-26': [
            new CalendarEvent('Back, Traps and Biceps')
        ],
        '2014-05-27': [
            new CalendarEvent('Chest, Triceps and Abs')
        ]
    };

    function animateEvent() {
        var getOtherDirection = function (currentDirection) {
            return currentDirection === 'up' ? 'down' : 'up';
        };

        $('.down, .up').click(function () {

            var $this = jQuery(this),
                    direction = $this.attr('class'),
                    otherDirection = getOtherDirection(direction),
                    $otherDirectionSpan = $this.siblings('.' + otherDirection);

            if ($this.data('offset') === undefined) {
                $this.data('offset', 0);
            }

            var $wrap = $this.closest('.scroll').siblings('.ev_wrap'),
                    wrapHeight = $wrap.height(),
                    $event = $wrap.find('.inner'),
                    length = $this.data('offset'),
                    height = $event.height(),
                    rest = height % wrapHeight,
                    item = parseInt(height / wrapHeight),
                    unit;

            if (rest > 0) {
                item = item + 1;
            }

            item = item - 1;

            if (direction === 'down') {
                length += wrapHeight;
                $this.siblings('span.up').removeClass('disable');
                if (length >= wrapHeight * item) {
                    $this.addClass('disable');
                }
            } else {
                length -= wrapHeight;
                $this.siblings('span.down').removeClass('disable');
                if (length == 0) {
                    $this.addClass('disable');
                }
            }

            $this.data('offset', length);
            $otherDirectionSpan.data('offset', length);

            if (direction && wrapHeight !== 0) {
                unit = (direction === 'down') ? '-=' : '+=';
            }
            $event.animate({'margin-top': unit ? (unit + wrapHeight ) : wrapHeight });
        });
    }



    var makeTwoDigit = function (n) {
        return n.toString().length > 1
                ? n
                : '0' + n;
    };

    function changeDayText() {

        setTimeout(function () {

            //$('.ui-datepicker-title').prepend('<div>CALENDAR EVENTS FOR</div>');
            $('table.ui-datepicker-calendar td').addClass('ui-datepicker-unselectable');
            $(".ui-datepicker-next").before($('.ui-datepicker-title'));
            var $table = $('.ui-datepicker-calendar tbody');

            //     set attribute data-month, data-year for other month "td"
            var attr_month = $table.find('td[data-month]').attr('data-month');
            var attr_year = $table.find('td[data-year]').attr('data-year');

            attr_month = parseInt(attr_month);

            $table.find('td[data-month]').first().prevAll().attr('data-month', attr_month - 1).attr('data-year', attr_year);
            $table.find('td[data-month]').last().nextAll().attr('data-month', attr_month + 1).attr('data-year', attr_year);


            $table.find('.event').each(function () {

                var $this = $(this),
                    newday,
                    year,
                    month,
                    day,
                    i,
                    length,
                    title;

                year = $this.attr('data-year');

                month = makeTwoDigit(
                    parseInt($this.attr('data-month')) + 1
                );

                day = makeTwoDigit(
                    $this.hasClass('ui-state-disabled')
                        ? $this.children('.ui-state-default').text()
                        : $this.children('a').text()
                );

                var key = year + '-' + month + '-' + day;

                if (allEvents[key] !== undefined) {
                    for (i = 0, length = allEvents[key].length; i < length; i++) {
                        title = allEvents[key][i].title ? allEvents[key][i].title : '';
                        newday = $this.html() + "<span class='new_ev'>" + allEvents[key][i].time + ' ' + title +"</span>";
                        $this.html(newday);
                    }
                }
            });

            //    add up - down buttons, for those td who has many events
            $('tbody td').each(function () {
                var $this = $(this).children('.new_ev');
                $this.wrapAll('<div class="inner" />');
                $this.closest('.inner').wrap('<div class="ev_wrap" />');

                var height = 0;
                $this.each(function () {
                    height += $(this).height();
                });

                if (height > $('.ev_wrap').height()) {
                    $this.closest('td').append("<span class='down'></span>");
                    $this.closest('td').append("<span class='up disable'></span>");
                }
                $this.closest('td').find('.down, .up').wrapAll('<div class="scroll" />');

            });

            //    move up, move down events
            animateEvent();

        }, 5);
    }

    $('#calendar').datepicker({
        inline: true,
        firstDay: 0,
        showOtherMonths: true,
        dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        prevText: 'PREVIOUS &#77;&#79;NTH',
        nextText: 'NEXT &#77;&#79;NTH',
        navigationAsDateFormat: true,
        onChangeMonthYear: changeDayText,
        beforeShowDay: function (date) {

            var result = [true, '', ''];
            var humanDate = new Date(date),
                year,
                month,
                day;

            year = humanDate.getFullYear();
            month =  makeTwoDigit(parseInt(humanDate.getMonth()) + 1);
            day = makeTwoDigit(humanDate.getDate());
            var key = year + '-' + month + '-' + day;

            if (allEvents[key] !== undefined){
                result = [true, 'event','hover'];
            }

            return result;
        }
    });

    changeDayText();
    $("table.ui-datepicker-calendar td").addClass('ui-datepicker-unselectable');
    $(".ui-datepicker-next").before($('.ui-datepicker-title'));
});