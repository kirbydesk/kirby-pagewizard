<template>
  <div
    class="pwIcon"
    :data-size="size"
    :data-color="color"
    :data-textalignment="textalignment"
		:style="color ? { color: color } : undefined"
  >
    <div v-html="icon" :style="theme === 'custom' && color ? { color: color } : undefined"></div>
  </div>
</template>

<script>
export default {
  name: "Icon",
  props: {
    theme: String,
    icon: String,
    size: String,
    textalignment: String,
    color: String
  }
};
</script>

<style scoped>
.pwIcon {
  display: flex;

  &[data-textalignment="center"]{
    justify-content: center;
  }

  &[data-size="large"]{
    div {
      width: 50px;

      svg {
        width: 50px;
        height: 50px;
      }
    }
  }

  div {
    width: 30px;

    svg {
      width: 30px;
      height: 30px;
      fill: currentColor;
    }
  }
}
</style>