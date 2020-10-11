<template>
    <div class="calendar">
        <div class="calendar-header row mb-3">
            <h3 class="calendar-month-indicator col-6">{{ selectedMonth }}</h3>
            <div class="calendar-date-selector col-6 text-right">
                <button class="btn btn-secondary" @click="selectPrevious">
                    &lt;
                </button>
                <button class="btn btn-secondary" @click="selectCurrent">
                    Today
                </button>
                <button class="btn btn-secondary" @click="selectNext">
                    &gt;
                </button>
            </div>
        </div>

        <ul class="list-group calendar-days">
            <li
                class="list-group-item calendar-day row d-flex"
                v-for="(day, dayIndex) in days"
                :key="dayIndex"
            >
                <div class="col-2">{{ formatToMonthDay(day.date) }}</div>
                <div class="col-10">
                    <span
                        class="badge badge-primary w-25 d-inline-block mx-1 mb-1"
                        v-for="event in day.events"
                        :key="event.event_key"
                        >
                            {{event.event_name}}
                        </span
                    >
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
import dayjs from "dayjs";

export default {
    props: {
        events: {
            type: Array,
            default: () => {
                return [];
            },
        },
    },
    data() {
        return {
            selectedDate: dayjs(),
        };
    },
    computed: {
        days() {
            return [...this.daysOfCurrentMonth];
        },

        today() {
            return dayjs().format("YYYY-MM-DD");
        },

        month() {
            return Number(this.selectedDate.format("MM"));
        },

        year() {
            return Number(this.selectedDate.format("YYYY"));
        },

        daysInMonth() {
            return dayjs(this.selectedDate).daysInMonth();
        },

        daysOfCurrentMonth() {
            return [...Array(this.daysInMonth)].map((day, index) => {
                let monthDay = dayjs(
                    `${this.year}-${this.month}-${index + 1}`
                ).format("YYYY-MM-DD");
                let eventsInDay = this.eventsInDay(monthDay);
                return {
                    date: monthDay,
                    events: eventsInDay,
                };
            });
        },

        selectedMonth() {
            return this.selectedDate.format("MMMM YYYY");
        },
    },

    methods: {
        getWeekday(date) {
            return dayjs(date).day();
        },

        selectDate(newSelectedDate) {
            this.selectedDate = newSelectedDate;
        },

        selectPrevious() {
            let newSelectedDate = dayjs(this.selectedDate).subtract(1, "month");
            this.selectDate(newSelectedDate);
        },

        selectCurrent() {
            let newSelectedDate = dayjs(this.today);
            this.selectDate(newSelectedDate);
        },

        selectNext() {
            let newSelectedDate = dayjs(this.selectedDate).add(1, "month");
            this.selectDate(newSelectedDate);
        },

        formatToMonthDay(date) {
            return dayjs(date).format("D ddd");
        },

        eventsInDay(date) {
            let events = this.events.filter((event) => {
                let theDateWeekDay = Number(dayjs(date).day()); //The day of the week 0-6
                let theDateUnix = dayjs(date).unix(); //Unix timestamp for the date
                let eventStart = dayjs(event.start_date).unix(); //Unix timestamp for event start date
                let eventEnd = dayjs(event.end_date).unix(); //Unix timestamp for event end date

                return (
                    theDateUnix >= eventStart &&
                    theDateUnix <= eventEnd &&
                    event.event_days.includes(theDateWeekDay)
                );
            });

            return events;
        },
    },
};
</script>