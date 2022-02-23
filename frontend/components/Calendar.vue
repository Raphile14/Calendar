<template>
    <div class="main">
        <div class="text-center">
            <button class="button__full" v-on:click="resetOffset()">This Month</button>
        </div>
        <hr />
        <div class="calendar">
            <div
                class="days"
                v-for="index in days"
                :key="`${index}`"
            >
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
                {{ index }}
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
export default {
    name: "Calendar",
    props: ["previousMonth", "currentMonth", "nextMonth"],
    data() {
        return {
            days: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
        };
    },
    methods: {
        resetOffset: function() {
            this.$emit("resetOffset");
        },
        dateClicked: function(day) {
            alert(day)
        }
    }
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
    background-color: #EFF1F3;
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
.previous__date, .next__date {
    background-color: #ccc;
}

.current__date:hover {
    background-color: #d5d6da;
}
</style>