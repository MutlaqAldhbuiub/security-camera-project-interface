<template>
  <div class="card-box">
    <div v-if="title" class="card-header text-center">
      <h5 class="card-title">
        {{ title }}
      </h5>
    </div>

    <div class="card-body">
      <slot />
    </div>
  </div>
</template>

<script>
export default {
  name: 'Card',

  props: {
    title: { type: String, default: null },
  }
}
</script>

<style scoped>
  .card-box{
    -webkit-box-shadow: 3px 2px 14px -2px rgba(0,0,0,0.51);
    -moz-box-shadow: 3px 2px 14px -2px rgba(0,0,0,0.51);
    box-shadow: 3px 2px 14px -2px rgba(0,0,0,0.51);

  }
  .card_application{
    position: relative;
    cursor: auto;
    box-sizing: border-box;
    border-radius: 6px;
    background-color: rgba(34, 45, 57, 0.9);
    inset: 0px;
    padding: 15px;
  }
</style>
