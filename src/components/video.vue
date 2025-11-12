<template>
	<div class="video" :class="size">
		<div class="pattern">
			<div v-if="url || videoUrl">
				<k-frame v-if="source == 'internal'" :ratio="computedRatio">
					<video :src="videoUrl" controls />
				</k-frame>
				<k-frame v-else-if="source == 'external'" ratio="16/9" class="external">
					<iframe :src="getEmbedUrl(url)" />
				</k-frame>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props: {
		url: String,
		source: String,
		size: String,
		video: Object
  },
	data() {
		return {
			videoContent: null
		}
	},
	computed: {
		computedRatio() {
			return this.videoContent?.videoratio || '16/9';
		},
		videoUrl() {
			return this.video?.url || this.video;
		}
	},
	async mounted() {
		if (this.video?.link) {
			await this.loadVideoContent();
		}
	},
  methods: {
		async loadVideoContent() {
			try {
				const response = await this.$api.get(this.video.link);
				this.videoContent = response?.content || null;
			} catch (error) {
				console.error('Error loading video content:', error);
			}
		},
    getEmbedUrl(url) {
      // YouTube
      if (url.includes('youtube.com/embed/') || url.includes('youtube-nocookie.com/embed/')) {
        return url;
      }
      const ytMatch = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([A-Za-z0-9_-]+)/);
      if (ytMatch && ytMatch[1]) {
        return `https://www.youtube-nocookie.com/embed/${ytMatch[1]}`;
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
div.video {
	width: 100%;

	div.pattern {
		background: var(--pattern);
	}
	iframe {
		width: 100%;
		display: block;
		border: 0;
	}
}
@media (min-width: 640px) {
	div.video {
		&.small {
			width: 25%;
		}
		&.medium {
			width: 50%;
		}
		&.large {
			width: 75%;
		}
		&.fullscreen {
			width: 100%;
		}
	}
}
</style>