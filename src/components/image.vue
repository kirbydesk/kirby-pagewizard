<template>
  <div class="image" :size="size">
		<div class="pattern">
			<figure
				class="k-frame k-image-frame k-image"
				:style="{
					'--fit': crop ? 'cover' : 'contain',
					'--ratio': ratio || '1/1'
				}"
			>
				<img v-if="src.length"
					:src="src"
					:srcset="srcset"
				/>
			</figure>
		</div>
		<div class="pwCaption">
			<div v-if="caption.length">
				{{ caption }}
			</div>
			<div v-else class="placeholder">
				{{ $t('pw.field.caption.placeholder') }}
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props: {
		src: String,
		srcset: String,
		crop: String,
		ratio: String,
		size: String,
		caption: String
  }
}
</script>

<style scoped>
.image {
	div.pattern {
		background: var(--pattern);
	}
}
div.pwCaption {
	font-style: italic;
  font-size: var(--text-sm);
  line-height: 1.2rem;
  opacity: 0.8;
	margin-top: 0.5rem;
	text-align: left;
}
</style>