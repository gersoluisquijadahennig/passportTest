<template>

<div class="q-pa-md">
        <div class="q-gutter-y-md" style="max-width: 100%">
            <q-card>
                <q-tabs v-model="tab" dense class="text-grey" active-color="primary" indicator-color="primary"
                    align="justify" narrow-indicator>
                    <q-tab name="edit" label="Editar Reino" />
                    <q-tab name="usuarios" label="Usuarios" />
                </q-tabs>

                <q-separator />

                <q-tab-panels v-model="tab" animated>
                    <q-tab-panel name="edit">
                        <div class="q-pa-md" style="max-width: 400px">
                            <q-form @submit="update" @reset="onReset" class="q-gutter-md">
                                <q-input filled v-model="form.name" label="Nombre *" hint="Nombre del Reino" lazy-rules
                                    :rules="[val => val && val.length > 0 || 'la descripcion no puede estar vacia']" />

                                <q-input filled v-model="form.description" label="Descripción *" lazy-rules :rules="[
                                    val => val !== null && val !== '' || 'Introduzca una descripción corta para el reino',
                                    val => val !== null && val.length > 10 || 'La descripción debe tener al menos 10 caracteres'
                                ]" />

                                <q-toggle v-model="form.active" label="Estado Activado/Desactivado" />

                                <div>
                                    <q-btn label="Guardar" type="submit" color="primary" />
                                    <q-btn label="Resetear" type="reset" color="secundary" flat class="q-ml-sm" />
                                </div>
                            </q-form>
                        </div>
                    </q-tab-panel>

                    <q-tab-panel name="usuarios">
                        <div class="text-h6">Listado de usuarios de este Reino</div>
                        <users :realm="props.realm" />
                    </q-tab-panel>

                </q-tab-panels>
            </q-card>
        </div>
    </div>




</template>

<script setup>
import { reactive, ref } from 'vue'
import { router, useForm } from '@inertiajs/vue3'
import Layout from '@/Layouts/Admin/Layout.vue'
import Users from './Users.vue'
defineOptions({ layout: Layout })

const props = defineProps({
    realm: {
        type: Object,
        required: true
    }
})

const tab = ref('edit')

var form = reactive(useForm({
    name: props.realm?.name || '',
    description: props.realm?.description || '',
    active: props.realm?.active || false,
}))

function update() {
    form.patch(route('admin.realm.update',{ realm : props.realm}),{
        onSuccess: () => {
            console.log('Realm update')
            onReset()
        },
        onError: (error) => {
            console.error('Error update realm:', error)
        }
    })
}

function onReset() {
    form.name = props.realm?.name || ''
    form.description = props.realm?.description || ''
    form.active = props.realm?.active || false
}
</script>
