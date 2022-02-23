<template>
    <div>
        <div class="text-center month__nav">
            <button v-on:click="modifyMonth(-1)"><BIconArrowBarLeft /></button>
            {{ month[currentMonth.month - 1] }} {{ currentMonth.year }}
            <button v-on:click="modifyMonth(1)"><BIconArrowBarRight /></button>
        </div>
        <hr />
        <b-form>
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
                />
            </b-form-group>

            <!-- Date To Input -->
            <b-form-group id="input-to" label="To:" label-for="to">
                <b-form-input
                    id="to"
                    name="to"
                    type="date"
                    placeholder="Select a date"
                    required
                />
            </b-form-group>

            <b-container class="text-center">
                <b-row>
                    <b-col class="col__button__left"
                        ><button class="submit__button" type="submit">
                            Add
                        </button></b-col
                    >
                    <b-col class="col__button__right"
                        ><button class="submit__button" type="submit">
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
    props: ["previousMonth", "currentMonth", "nextMonth", "offset"],
    data() {
        return {
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
    methods: {
        modifyMonth: function (value) {
            this.$emit("modifyOffset", value);
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
.col__button__right, .col__button__left {
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
</style>