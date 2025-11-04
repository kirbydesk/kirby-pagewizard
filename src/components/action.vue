<template>
  <div class="pwAction" v-if="link && link.length !== 0">
		<div v-if="linktext">{{ linktext }}</div>
    <div v-else>{{ $t('pw.action.readmore') }}</div>
    <div v-if="linktarget == 'blank'">
      <svg aria-hidden="true" data-type="open">
        <use xlink:href="#icon-open"></use>
      </svg>
    </div>
  </div>
</template>

<script>
export default {
  props: {
		link: String,
		linktarget: String,
		linktext: String,
		linktitle: String
  }
}
</script>
<style scoped>
div.pwAction {
  display: flex;
  gap: 5px;
  padding-top: var(--spacing-2);

  svg {
    height: 15px;
    width: 15px;
  }
}
</style>