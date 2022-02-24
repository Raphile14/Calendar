<template>
    <div id="modal" class="modal__overlay" @click.self="$emit('toggleModal')">
        <div class="modal__object">
            <div class="close__modal text-right">
                <button @click="$emit('toggleModal')">Close</button>
            </div>
            <h1>Events for {day}!</h1>
            <p>Your Details have been saved Successfully</p>
        </div>
    </div>
</template>

<script>
export default {
    name: "EventDayModal",
    created: function () {

    }
};
</script>

<style>
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