<template>
    <b-container
        class="border__main calendar__container centered modal-overlay"
        align-v="center"
    >
        <b-row>
            <b-col class="left__side">
                <InputForm
                    :currentMonth="currentMonth"
                    :previousMonth="previousMonth"
                    :nextMonth="nextMonth"
                    :offset="offset"
                    :month="month"
                    v-on:modifyOffset="modifyOffset($event)"
                    v-on:refreshCalendar="refreshCalendar()"
                />
            </b-col>
            <b-col>
                <Calendar
                    :currentMonth="currentMonth"
                    :previousMonth="previousMonth"
                    :nextMonth="nextMonth"
                    :data="data"
                    :month="month"
                    v-on:resetOffset="resetOffset()"
                    v-on:refreshCalendar="refreshCalendar()"
                />
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
export default {
    name: "Main",
    async fetch() {
        // Get data from backend
        let response = await this.$axios.get(
            `/api/calendars?month=${
                this.currentMonth.now.getMonth() + 1
            }&year=${this.currentMonth.now.getFullYear()}&nextMonth=${
                this.nextMonth.next.getMonth() + 1
            }&nextYear=${this.nextMonth.next.getFullYear()}`
        );
        let newData = [];

        // Generate array of events for each day
        for (let x = 1; x <= this.currentMonth.totalDays; x++) {
            newData[x] = [];
        }

        // Assign events per day
        for (let x = 0; x < response.data.length; x++) {
            let date = new Date(response.data[x].time);
            let event = response.data[x];

            // Slice string if longer than 5 characters
            event.shortTitle = event.title;
            if (event.title.length > 6) {
                event.shortTitle = `${event.title.substring(0, 4)}...`;
            }
            newData[date.getDate()].push(event);
        }

        this.data = newData;
    },
    data() {
        return {
            currentMonth: {},
            previousMonth: {},
            nextMonth: {},
            offset: 0,
            data: [],
            month: [
                "January",
                "February",
                "March",
                "April",
                "May",
                "June",
                "July",
                "August",
                "September",
                "October",
                "November",
                "December",
            ],
        };
    },
    created() {
        this.generateData();
    },
    methods: {
        modifyOffset: function (value) {
            this.offset += value;
            this.generateData();
        },
        refreshCalendar: function () {
            this.generateData();
        },
        resetOffset: function () {
            this.offset = 0;
            this.generateData();
        },
        generateData: async function () {
            // Generate data for current month
            let now = new Date();
            now = new Date(`${now.getFullYear()} ${now.getMonth() + 1} 1`);
            let prev = new Date(`${now.getFullYear()} ${now.getMonth() + 1} 1`);
            let next = new Date(`${now.getFullYear()} ${now.getMonth() + 1} 1`);

            // Set month offsets
            now.setMonth(now.getMonth() + this.offset);
            prev.setMonth(prev.getMonth() + this.offset);
            prev.setDate(0);
            next.setMonth(next.getMonth() + this.offset + 1);
            this.currentMonth = {
                month: now.getMonth() + 1,
                year: now.getFullYear(),
                totalDays: new Date(
                    now.getFullYear(),
                    now.getMonth() + 1,
                    0
                ).getDate(),
                firstDay: new Date(
                    now.getFullYear(),
                    now.getMonth(),
                    1
                ).getDay(),
                lastDay: new Date(
                    now.getFullYear(),
                    now.getMonth() + 1,
                    0
                ).getDay(),
                now,
            };

            // Generate last days of the previous month
            let previousDays = [];
            for (let x = this.currentMonth.firstDay - 1; x >= 0; x--) {
                previousDays.push(prev.getDate() - x);
            }

            // Assign values to previous month
            this.previousMonth = {
                month: prev.getMonth() + 1,
                year: prev.getFullYear(),
                previousDays,
            };

            // Generate data for next month
            let nextDays = [];
            for (let x = 1; x < 7 - this.currentMonth.lastDay; x++) {
                nextDays.push(x);
            }

            // Assign values for next month
            this.nextMonth = {
                month: next.getMonth() + 1,
                year: next.getFullYear(),
                nextDays,
                next,
            };

            // Fetch new data
            await this.$fetch();
        },
    },
};
</script>

<style>
body {
    background-color: #fbfcff;
    color: #4b7d96;
    font-weight: 700;
}
button {
    padding: 0;
    border: none;
    background: none;
}
.centered {
    margin-top: 1%;
    width: 100%;
}
.calendar__container {
    padding: 5%;
}
.border__main {
    border: 1px solid #4b7d96;
    border-radius: 1%;
}
.left__side {
    max-width: 40%;
}
/* .modal-overlay {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    display: flex;
    justify-content: center;
    background-color: #000000da;
} */
</style>