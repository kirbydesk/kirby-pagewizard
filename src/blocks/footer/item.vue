<template>
	<div @dblclick="open">
		<div
			class="pwPreview"
			data-block="footer"
			>
			<div v-if="content.name">
				{{ content.name }}
			</div>
			<div v-else class="placeholder">
			{{ $t('pw.block.footer.item.name') }}
			</div>
		</div>
	</div>
</template>