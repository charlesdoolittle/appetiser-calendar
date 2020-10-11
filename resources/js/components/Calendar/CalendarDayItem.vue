<template>
    <li class="list-group-item calendar-day row d-flex">
        <div class="col-2">{{ day }}</div>
        <div class="col-10">
            <span class="badge badge-primary w-100 d-block mb-1"
                >Some event here</span
            >
        </div>
    </li>
</template>

<script>
export default {
    props: {
        day: {
            type: String,
            default: ''
        }
    }
};
</script>