<template>
    <div>
        <div class="text-center month__nav">
            <button v-on:click="modifyMonth(-1)"><BIconArrowBarLeft /></button>
            {{ month[currentMonth.month - 1] }} {{ currentMonth.year }}
            <button v-on:click="modifyMonth(1)"><BIconArrowBarRight /></button>
        </div>
        <hr />
        <b-form v-on:submit.prevent="submit($event)">
            <!-- Event Name Input -->
            <b-form-group
                id="input-title"
                label="Event Name:"
                label-for="title"
            >
                <b-form-input
                    id="title"
                    name="title"
                    type="text"
                    v-model="title"
                    placeholder="Event Name"
                    maxlength="30"
                    required
                />
            </b-form-group>

            <!-- Event Description Input -->
            <b-form-group
                id="input-description"
                label="Event Description:"
                label-for="title"
            >
                <b-form-textarea
                    id="body"
                    name="body"
                    type="text"
                    v-model="body"
                    class="text__area"
                    placeholder="Event Description"
                    maxlength="60"
                    required
                />
            </b-form-group>

            <!-- Date From Input -->
            <b-form-group id="input-from" label="From:" label-for="from">
                <b-form-input
                    id="from"
                    name="from"
                    type="date"
                    placeholder="Select a date"
                    required
                    v-model="from"
                    @change="selectMonth"
                />
            </b-form-group>

            <!-- Date To Input -->
            <b-form-group id="input-to" label="To:" label-for="to">
                <b-form-input
                    id="to"
                    name="to"
                    type="date"
                    placeholder="Select a date"
                    v-model="to"
                    required
                    :min="from"
                    @change="selectToMonth"
                />
            </b-form-group>

            <!-- Day Checkboxes -->
            <div class="checkboxes">
                <b-form-group
                    v-if="Object.keys(selectedDays).length > 0"
                    id="checkbox-label"
                    label="Select days:"
                >
                    <b-form-checkbox
                        :id="`${index}`"
                        :v-model="`${index}`"
                        :name="`${index}`"
                        :value="`${index}`"
                        v-for="index in selectedDays"
                        :key="`${index}`"
                    >
                        {{ index }}
                    </b-form-checkbox>
                </b-form-group>
                <p v-if="errorDays" class="error">Please select a day</p>
            </div>

            <b-container class="text-center">
                <b-row>
                    <b-col class="col__button__left"
                        ><button class="submit__button" type="submit" v-on:click="oride(false)">
                            Add
                        </button></b-col
                    >
                    <b-col class="col__button__right"
                        ><button class="submit__button" type="submit" v-on:click="oride(true)">
                            Override
                        </button></b-col
                    >
                </b-row>
            </b-container>
        </b-form>
    </div>
</template>

<script>
import { BIconArrowBarLeft, BIconArrowBarRight } from "bootstrap-vue";
export default {
    name: "InputForm",
    components: {
        BIconArrowBarLeft,
        BIconArrowBarRight,
    },
    props: ["previousMonth", "currentMonth", "nextMonth", "offset", "month"],
    data() {
        return {
            days: [
                "Sunday",
                "Monday",
                "Tuesday",
                "Wednesday",
                "Thursday",
                "Friday",
                "Saturday",
            ],
            Sunday: false,
            selectedDays: {},
            to: "",
            from: "",
            title: "",
            body: "",
            errorDays: false,
            override: false,
        };
    },
    methods: {
        oride: function (value) {
            this.override = value;
        },
        modifyMonth: function (value) {
            this.$emit("modifyOffset", value);
        },        
        selectMonth: function () {
            this.to = "";
            this.selectedDays = {};
            this.errorDays = false;
        },
        selectToMonth: function () {
            // Generate a list of selected days
            if (this.to.length > 0 && this.from.length > 0) {
                let from = new Date(this.from);
                let to = new Date(this.to);
                let selectedDays = {};

                while (from <= to) {
                    if (!selectedDays[from.getDay()]) {
                        selectedDays[from.getDay()] = this.days[from.getDay()];
                    }
                    from.setDate(from.getDate() + 1);
                }
                this.selectedDays = selectedDays;
            }
        },
        submit: async function (e) {
            let checkedDays = [];
            let days = [];

            // Get selected days
            for (const [key, value] of Object.entries(this.selectedDays)) {
                if (document.getElementById(value).checked)
                    checkedDays.push(parseInt(key));
            }

            // Get list of exact days
            let from = new Date(this.from);
            let to = new Date(this.to);

            while (from <= to) {
                if (checkedDays.includes(from.getDay())) {
                    let dateToAdd = new Date(from);
                    days.push(`${dateToAdd.getFullYear()}-${dateToAdd.getMonth() + 1}-${dateToAdd.getDate()}`);
                }
                from.setDate(from.getDate() + 1);
            }

            if (checkedDays.length == 0) {
                this.errorDays = true;
                return;
            }
            this.errorDays = false;
            await this.$axios({
                method: "post",
                url: "/api/calendars",
                data: {
                    title: this.title,
                    body: this.body,
                    days,
                    override: this.override
                },
            });
            this.$emit("refreshCalendar");
        },
    },
};
</script>

<style>
.submit__button {
    width: 100%;
    padding: 0;
    border: none;
    color: #ffffff;
    background: #4b7d96;
    padding-top: 4%;
    padding-bottom: 4%;
    border-radius: 5px;
}
.col__button__right,
.col__button__left {
    padding: 0;
}

.col__button__left {
    padding-right: 1%;
}

.col__button__right {
    padding-left: 1%;
}

.month__nav {
    display: flex;
    justify-content: space-between;
    flex-direction: row;
}

.text__area {
    resize: none;
}
.checkboxes {
    padding-top: 1%;
    padding-bottom: 5%;
}
.error {
    color: rgb(240, 82, 82);
}
</style>