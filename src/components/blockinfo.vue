<template>
  <div class="blockinfo">
    <!-- with a block type the whole label leads to its design in the
         Project Wizard -->
    <div
      :class="{ 'is-link': design }"
      :title="design ? $t('pw.blockinfo.design') : null"
      :role="design ? 'link' : null"
      @click="go"
    >
      <svg aria-hidden="true" class="k-icon">
        <use :xlink:href="'#icon-' + icon"></use>
      </svg>
      {{ value }}
      <span v-if="layout">({{ layout }})</span>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    value: String,
    icon: String,
    layout: String,
    // the block type: a button to its design in the Project Wizard
    design: String
  },
  methods: {
    go(event) {
      if (!this.design) return;
      event.stopPropagation();
      this.$go('projectwizard/block/' + this.design);
    }
  }
}
</script>
<style scoped>
div.blockinfo div {
  display: none;
  position: absolute;
  top: 0;
  /* as high and as placed as Kirby's block toolbar on the right (30px,
     its border included; above the block) */
  margin-top: calc(-1.75rem + 2px);
	margin-left: var(--spacing-2);
  font-size: var(--text-xs);
  height: 30px;
  box-sizing: border-box;
  padding: 0 var(--spacing-2) 0 var(--spacing-1);
  border-radius: var(--rounded-md);
  box-shadow: var(--shadow-xl);
  font-weight: var(--font-thin);
  align-items: center;
  z-index: var(--z-toolbar);
	color: white;
	background-color: var(--color-blue-600);

  svg {
    display: block;
    height: var(--text-md);
		fill: #c4dff9
  }
}
/* the label as a link to the design */
div.blockinfo div.is-link {
  cursor: pointer;
}
div.blockinfo div.is-link:hover {
  background-color: var(--color-blue-700, #1d4ed8);
}
</style>