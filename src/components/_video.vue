<template>
	<div class="video" :size="size">
		<div class="pattern">


			<div v-if="videourl || video">

				<k-frame v-if="videosource == 'internal'" :ratio="ratio">
					<template>
						<video
							:src="video"
							controls
						/>
					</template>
				</k-frame>

				<k-frame v-else-if="videosource == 'external'" ratio="16/9" class="external">
					<iframe
						:src="getEmbedUrl(videourl)"
					/>
				</k-frame>
			</div>

			<div v-else style="height: 300px"></div>

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
		videourl: String,
		videosource: String,
		ratio: String,
		size: String,
		caption: String,
		video: String
  },
  methods: {
    getEmbedUrl(url) {
      // YouTube
      if (url.includes('youtube.com/embed/')) return url;
      const ytMatch = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([A-Za-z0-9_-]+)/);
      if (ytMatch && ytMatch[1]) {
        return `https://www.youtube.com/embed/${ytMatch[1]}`;
      }
      // Vimeo
      const vimeoMatch = url.match(/vimeo\.com\/(?:video\/)?(\d+)/);
      if (vimeoMatch && vimeoMatch[1]) {
        return `https://player.vimeo.com/video/${vimeoMatch[1]}`;
      }
      // Fallback
      return url;
    }
  }
}
</script>

<style scoped>
.video {
	width: 100%;

	&[size="small"]{
		min-width: 30%;
	}
	&[size="medium"]{
		min-width: 40%;
	}
	&[size="large"]{
		min-width: 50%;
	}
	@media (min-width: 800px) {
		&[size="small"]{
			min-width: unset;
			max-width: 300px;
		}
		&[size="medium"]{
			min-width: unset;
			max-width: 400px;
		}
		&[size="large"]{
			min-width: unset;
			max-width: 500px;
		}
	}

	iframe {
		width: 100%;
		display: block;
		border: 0;
	}

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