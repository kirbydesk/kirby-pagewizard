<template>
	<div class="pwPreview" @dblclick="open">
		<div v-if="content.linktext">
			{{ content.linktext }}
		</div>
		<div v-else class="placeholder">
			{{ $t('pw.field.link-text.placeholder') }}
		</div>
	</div>
</template>