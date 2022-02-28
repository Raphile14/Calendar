<template>
    <div class="main">
        <EventDayModal
            v-show="showModal"
            v-on:toggleModal="toggleModal()"
            v-on:refreshCalendar="refreshCalendar()"
            :data="data"
            :day="day"
            :month="month"
            :currentMonth="currentMonth"
        />
        <div class="text-center">
            <button class="button__full" v-on:click="resetOffset()">
                This Month
            </button>
        </div>
        <hr />
        <div class="calendar">
            <div class="days" v-for="index in days" :key="`${index}`">
                {{ index }}
            </div>

            <div
                class="previous__date"
                v-for="index in previousMonth.previousDays"
                :key="`prev__${index}`"
            >
                {{ index }}
            </div>
            <div
                class="current__date"
                v-for="index in currentMonth.totalDays"
                :id="`day__${index}`"
                :key="`curr__${index}`"
                role="button"
                v-on:click="dateClicked(index)"
            >
                <p>{{ index }}</p>
                <p
                    class="event__entry"
                    v-for="val in data[index]"
                    :key="`${val.id}`"
                >
                    {{ val.shortTitle }}
                </p>
            </div>
            <div
                class="next__date"
                v-for="index in nextMonth.nextDays"
                :key="`next__${index}`"
            >
                {{ index }}
            </div>
        </div>
    </div>
</template>

<script>
import EventDayModal from "./EventDayModal.vue";
export default {
    components: { EventDayModal },
    name: "Calendar",
    props: ["previousMonth", "currentMonth", "nextMonth", "data", "month"],
    data() {
        return {
            days: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
            showModal: false,
            day: null,
        };
    },
    methods: {
        toggleModal: function () {
            this.showModal = !this.showModal;
        },
        resetOffset: function () {
            this.$emit("resetOffset");
        },
        dateClicked: function (day) {
            this.day = day;
            this.toggleModal();
            // alert(day);
        },
        refreshCalendar: function () {
            this.$emit("refreshCalendar");
        },
    },
    created() {},
};
</script>

<style>
.main {
    height: 87%;
}
.calendar {
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    background-color: #eff1f3;
    height: 100%;
}
.calendar > div {
    width: 14.28571429%;
    text-align: center;
}
.button__full {
    width: 100%;
    padding: 0;
    border: none;
    color: white;
    background: #628596;
    border-radius: 5px;
}

/* Columns */
.days {
    border-bottom: 1px solid black;
    display: flex;
    align-items: center;
    justify-content: center;
}
.previous__date,
.next__date {
    background-color: #ccc;
}
.current__date {
    background-color: #eff1f3;
    font-size: small;
}
.current__date:hover {
    background-color: #d5d6da;
}
.event__entry {
    color: black;
    padding: 0px;
    margin: 0px;
    font-size: small;
}
</style>