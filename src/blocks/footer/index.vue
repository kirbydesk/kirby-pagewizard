<template>
	<div @dblclick="open">
		<div
			class="pwPreview"
			data-block="footer"
			>
			<div v-if="content.category">
				{{ content.category }}
			</div>
			<div v-else class="placeholder">
			{{ $t('pw.field.category.placeholder') }}
			</div>
		</div>
	</div>
</template>