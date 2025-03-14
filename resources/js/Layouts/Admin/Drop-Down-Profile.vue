<template>
  <q-btn-dropdown>
    <div class="row no-wrap q-pa-md">
      <div class="column">
        <div class="text-h6 q-mb-md">Configuración</div>
        <q-toggle :model-value="darkMode" @update:model-value="updateDarkMode" label="Modo Oscuro" />
      </div>

      <q-separator vertical inset class="q-mx-lg" />

      <div class="column items-center">
        <q-avatar size="72px">
          <img src="https://cdn.quasar.dev/img/boy-avatar.png">
        </q-avatar>

        <div class="text-subtitle1 q-mt-md q-mb-xs">{{ page.props.auth.user.alias }}</div>

        <q-btn color="primary" label="Logout" push size="sm" v-close-popup @click="logout" />
      </div>
    </div>
  </q-btn-dropdown>
</template>

<script setup>

import { usePage } from '@inertiajs/vue3'
const page = usePage()

const props = defineProps({
  darkMode: {
    type: Boolean,
    required: true
  }
})

const emit = defineEmits(['update:darkMode'])

const updateDarkMode = (value) => {
  emit('update:darkMode', value)
}


const logout = async () => {
  try {
    await axios.post('/admin/logout')
    window.location.href = '/admin/login' // Redirigir al usuario a la página de inicio de sesión
  } catch (error) {
    console.error('Error logging out:', error)
  }
}

</script>
