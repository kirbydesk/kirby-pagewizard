<template>
  <!-- a heading with its toggles on the right (icons only) – e.g. a
       column's heading with its vertical position; the value is stored as
       Kirby's toggles field stores it -->
  <div :class="['k-field', 'k-headline-field', 'pw-headtoggles-field', $attrs.class]" :style="$attrs.style">
    <div class="pw-breakpoints-head">
      <k-headline class="h2">{{ label }}</k-headline>
      <k-toggles-input
        :id="id"
        :value="value"
        :options="options"
        :labels="false"
        :required="required"
        :disabled="disabled"
        class="pw-headtoggles-input"
        @input="$emit('input', $event)"
      />
    </div>
    <footer v-if="help" class="k-field-footer">
      <k-text class="k-help k-field-help" :html="help" />
    </footer>
  </div>
</template>

<script>
export default {
  extends: 'k-toggles-field',
  inheritAttrs: false,
};
</script>

<style>
/* the toggles as small as their icons */
.pw-headtoggles-input {
  flex: 0 0 auto;
  width: auto;
}
.pw-headtoggles-input ul {
  display: inline-flex;
}
</style>
