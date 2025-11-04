<template>
	<div class="pwPreview" @dblclick="open">
		<div class="heading" v-if="content.name">
			{{ content.name }}
		</div>
		<div v-else class="heading placeholder">
			{{ $t('pw.footer.name') }} ...
		</div>
		<div class="items" v-for="item in content.blocks" :key="item.id">
			<div :class="{ placeholder: !item.content.linktext }">
				{{ item.content.linktext || $t('pw.field.link-text.placeholder') }}
			</div>
		</div>
	</div>
</template>