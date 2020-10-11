<template>
    <div class="bg-secondary">
        <div class="container-fluid py-4">
            <div class="card">
                <div class="card-header">
                    <h1 class="h3">Events Calendar</h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <form id="event-form" @submit.prevent="saveEvent">
                                <div class="form-group">
                                    <label for="event-name">Event</label>
                                    <input
                                        type="text"
                                        id="event-name"
                                        class="form-control"
                                        placeholder="Enter event name"
                                        v-model="event.event_name"
                                        required
                                    />
                                </div>

                                <div class="row form-group">
                                    <div class="col-6">
                                        <label for="start-date">From</label>
                                        <input
                                            type="date"
                                            class="form-control"
                                            id="start-date"
                                            v-model="event.start_date"
                                            required
                                        />
                                    </div>
                                    <div class="col-6">
                                        <label for="end-date">To</label>
                                        <input
                                            type="date"
                                            class="form-control"
                                            id="end-date"
                                            v-model="event.end_date"
                                            required
                                        />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check form-check-inline">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            id="evtDayCheck1"
                                            :value="0"
                                            v-model="event.event_days"
                                        />
                                        <label
                                            class="form-check-label"
                                            for="evtDayCheck1"
                                            >Sun</label
                                        >
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            id="evtDayCheck2"
                                            :value="1"
                                            v-model="event.event_days"
                                        />
                                        <label
                                            class="form-check-label"
                                            for="evtDayCheck2"
                                            >Mon</label
                                        >
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            id="evtDayCheck3"
                                            :value="2"
                                            v-model="event.event_days"
                                        />
                                        <label
                                            class="form-check-label"
                                            for="evtDayCheck3"
                                            >Tue</label
                                        >
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            id="evtDayCheck4"
                                            :value="3"
                                            v-model="event.event_days"
                                        />
                                        <label
                                            class="form-check-label"
                                            for="evtDayCheck4"
                                            >Wed</label
                                        >
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            id="evtDayCheck5"
                                            :value="4"
                                            v-model="event.event_days"
                                        />
                                        <label
                                            class="form-check-label"
                                            for="evtDayCheck5"
                                            >Thu</label
                                        >
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            id="evtDayCheck6"
                                            :value="5"
                                            v-model="event.event_days"
                                        />
                                        <label
                                            class="form-check-label"
                                            for="evtDayCheck6"
                                            >Fri</label
                                        >
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            id="evtDayCheck7"
                                            :value="6"
                                            v-model="event.event_days"
                                        />
                                        <label
                                            class="form-check-label"
                                            for="evtDayCheck7"
                                            >Sat</label
                                        >
                                    </div>
                                </div>

                                <button
                                    class="btn btn-primary"
                                    type="submit"
                                    :class="{ disabled: isSaving }"
                                    :disabled="isSaving"
                                >
                                    <span v-show="isSaving">Saving...</span>
                                    <span v-show="!isSaving">Save</span>
                                </button>
                            </form>
                        </div>
                        <div class="col-8">
                            <calendar :events="events"></calendar>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Calendar from "./Calendar/Calendar";

export default {
    components: {
        Calendar,
    },
    data() {
        return {
            event: {
                event_name: "",
                start_date: null,
                end_date: null,
                event_days: [],
            },
            events: [],
            isSaving: false,
        };
    },
    created() {
        axios.get("/api/events").then((response) => {
            this.events = response.data.events;
        });
    },
    methods: {
        getEvents() {},

        saveEvent() {
            this.isSaving = true;

            axios
                .post("/api/events/save", this.event)
                .then((response) => {
                    let savedEvent = response.data.event;
                    let existingEvent = this.events.findIndex(
                        (event) => event.event_key == savedEvent.event_key
                    );

                    if (existingEvent == -1) {
                        this.events.push(response.data.event);
                    } else {
                        this.events[existingEvent].event_name =
                            savedEvent.event_name;
                        this.events[existingEvent].event_days =
                            savedEvent.event_days;
                    }
                })
                .catch((error) => {})
                .then(() => {
                    this.isSaving = false;
                });
        },
    },
};
</script>