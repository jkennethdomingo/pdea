<script setup>
import { onMounted } from 'vue'
import { gsap } from 'gsap'

onMounted(() => {
    // TODO jd
    gsap.to('#loading .logo', { y: -50, opacity: 0, duration: 1 })
    gsap.to('#loading .left', {
        rotateY: 90,
        x: '-400%',
        duration: 1,
        delay: 0.6,
    })
    gsap.to('#loading .right', {
        rotateY: -90,
        x: '400%',
        duration: 1,
        delay: 0.6,
        onComplete: () => {
            document.getElementById('loading')?.remove()
        },
    })
})
</script>

<template>
    <router-view />
</template>
