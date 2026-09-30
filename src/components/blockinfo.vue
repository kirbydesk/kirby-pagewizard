<template>
  <div class="blockinfo">
    <div>
      <svg aria-hidden="true" class="k-icon">
        <use :xlink:href="'#icon-' + icon"></use>
      </svg>
      <!-- the name: with a block type a link to its design in the Project
           Wizard -->
      <button
        v-if="design"
        type="button"
        class="blockinfo-design"
        :title="$t('pw.blockinfo.design')"
        @click.stop="$go('projectwizard/block/' + design)"
        @dblclick.stop
        @mousedown.stop
      >{{ value }}</button>
      <template v-else>{{ value }}</template>
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
  }
}
</script>
<style scoped>
div.blockinfo div {
  display: none;
  position: absolute;
  top: 0;
  margin-top: calc(var(--spacing-4) * -1);
	margin-left: var(--spacing-2);
  font-size: var(--text-xs);
  height: calc(var(--toolbar-size) - 8px);
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
/* the name as a link to the design */
.blockinfo-design {
  display: inline;
  padding: 0;
  color: white;
  font: inherit;
  cursor: pointer;
}
.blockinfo-design:hover {
  text-decoration: underline;
}
</style>