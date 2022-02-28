<template>
    <div id="modal" class="modal__overlay" @click.self="$emit('toggleModal')">
        <div class="modal__object">
            <div class="close__modal text-right">
                <button @click="$emit('toggleModal')">Close</button>
            </div>
            <h1>
                Events for {{ month[currentMonth.month - 1] }} {{ day }},
                {{ currentMonth.year }}
            </h1>
            <p v-if="data[day] && data[day].length == 0">No events today</p>
            <div v-if="data[day] && data[day].length > 0">
                <ol>
                    <li
                        class="text-center event__entry__modal"
                        v-for="index in data[day]"
                        :key="`${index.id}`"
                    >
                        <form v-on:submit.prevent="submit($event)">
                            <b-container>
                                <b-row>
                                    <input
                                        type="hidden"
                                        name="id"
                                        :value="index.id"
                                    />
                                    <b-col>
                                        <b-form-input
                                            id="title"
                                            ref="title"
                                            name="title"
                                            type="text"
                                            placeholder="Event Name"
                                            maxlength="30"
                                            :value="index.title"
                                            required
                                        />
                                    </b-col>
                                    <b-col>
                                        <b-form-input
                                            id="body"
                                            name="body"
                                            ref="body"
                                            type="text"
                                            class="text__area__modal"
                                            placeholder="Event Description"
                                            maxlength="60"
                                            :value="index.body"
                                            required
                                        />
                                    </b-col>
                                    <b-col>
                                        <b-container class="text-center">
                                            <b-row>
                                                <b-col
                                                    class="
                                                        col__button__left__modal
                                                    "
                                                >
                                                    <button
                                                        type="submit"
                                                        class="
                                                            submit__button__modal
                                                        "
                                                    >
                                                        Save
                                                    </button>
                                                </b-col>
                                                <b-col
                                                    class="
                                                        col__button__right__modal
                                                    "
                                                >
                                                    <button
                                                        type="button"
                                                        v-on:click="
                                                            deleteEvent(
                                                                index.id
                                                            )
                                                        "
                                                        class="
                                                            submit__button__modal
                                                        "
                                                    >
                                                        Delete
                                                    </button>
                                                </b-col>
                                            </b-row>
                                        </b-container>
                                    </b-col>
                                </b-row>
                            </b-container>
                        </form>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "EventDayModal",
    props: ["data", "day", "currentMonth", "month"],
    methods: {
        submit: async function (e) {
            try {
                const id = e.target[0].value;
                const title = e.target[1].value;
                const body = e.target[2].value;
                await this.$axios({
                    method: "put",
                    url: `/api/calendars/${id}`,
                    data: {
                        title,
                        body,
                    },
                });
                this.$emit("refreshCalendar");
            } catch (error) {
                alert("Failed to update event");
            }
        },
        deleteEvent: async function (id) {
            try {
                await this.$axios({
                    method: "delete",
                    url: `/api/calendars/${id}`,
                });
                this.$emit("refreshCalendar");
            } catch (error) {
                alert("Failed to delete event");
            }
        },
    },
};
</script>

<style>
/* Submit Button */
.event__entry__modal {
    color: black;
    padding-top: 1%;
    margin: 0px;
    font-size: small;
}

.submit__button__modal {
    width: 100%;
    padding: 0;
    border: none;
    color: #ffffff;
    background: #4b7d96;
    padding-top: 4%;
    padding-bottom: 4%;
    border-radius: 5px;
}

.col__button__right__modal,
.col__button__left__modal {
    padding: 0;
}

.col__button__left__modal {
    padding-right: 1%;
}

.col__button__right__modal {
    padding-left: 1%;
}

/* Modal */
.modal__overlay {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    display: flex;
    justify-content: center;
    background-color: #000000da;
    z-index: 999;
}
.modal__object {
    text-align: center;
    background-color: #fbfcff;
    height: 80%;
    width: 90%;
    margin-top: 5%;
    padding: 1% 0;
    border-radius: 20px;
    z-index: 1000;
}
.close__modal {
    padding-right: 10%;
}
</style>