<template>
	<div class="pwPreview" @dblclick="open">

		<div v-if="content.linktext" class="linktext">
			<span>{{ content.linktext }}</span>
			<span v-if="content.linktarget" class="k-icon">
				<k-icon type="open" />
      </span>
		</div>
		<div v-else class="placeholder">
			{{ $t('pw.field.link-text.placeholder') }}
		</div>
	</div>
</template>
<style scoped>
div.pwPreview {
	padding: var(--spacing-3);
}
</style>
