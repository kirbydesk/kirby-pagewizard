<template>
	<div class="pwPreview" @dblclick="open">
		<div class="heading" v-if="content.name">
			{{ content.name }}
		</div>
		<div v-else class="heading placeholder">
			{{ $t('pw.footer.name') }} ...
		</div>
		<div class="items" v-for="item in content.blocks" :key="item.id">
			<div class="linktext" :class="{ placeholder: !item.content.linktext }">
				<span>{{ item.content.linktext || $t('pw.field.link-text.placeholder') }}</span>
				<span v-if="item.content.linktarget" class="k-icon">
					<k-icon type="open" />
				</span>
			</div>
		</div>
	</div>
</template>
<style scoped>
div.pwPreview {
	padding: var(--spacing-3);

	div.heading {
		font-weight: var(--font-bold);
		margin-bottom: var(--spacing-2);
	}

	div.items {
		padding-left: var(--spacing-1);
	}
}
</style>
