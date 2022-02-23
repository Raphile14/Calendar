<template>
    <b-container
        class="border border-dark calendar__container centered"
        align-v="center"
    >
        <b-row>
            <b-col class="left__side">
                <InputForm
                    :currentMonth="currentMonth"
                    :previousMonth="previousMonth"
                    :nextMonth="nextMonth"
                    :offset="offset"
                    v-on:modifyOffset="modifyOffset($event)"
                />
            </b-col>
            <b-col>
                <Calendar
                    :currentMonth="currentMonth"
                    :previousMonth="previousMonth"
                    :nextMonth="nextMonth"
                    v-on:resetOffset="resetOffset()"
                />
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
export default {
    name: "Main",
    data() {
        return {
            currentMonth: {},
            previousMonth: {},
            nextMonth: {},
            offset: 0,
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
        resetOffset: function () {
            this.offset = 0;
            this.generateData();
        },
        generateData: function () {
            // Generate data for current month
            let now = new Date();
            now = new Date(`${now.getFullYear()} ${now.getMonth() + 1} 1`);
            let prev = new Date(`${now.getFullYear()} ${now.getMonth() + 1} 1`);
            let next = new Date(`${now.getFullYear()} ${now.getMonth() + 1} 1`);
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
            this.nextMonth = {
                month: next.getMonth() + 1,
                year: next.getFullYear(),
                nextDays,
            };
        },
    },
};
</script>

<style>
body {
    background-color: #fbfcff;
    color: #4b7d96;
    font-weight: 600;
}
button {
    padding: 0;
    border: none;
    background: none;
}
.centered {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
.calendar__container {
    padding: 5%;
}
.border {
    border-radius: 1%;
}
.left__side {
    max-width: 40%;
}
</style>