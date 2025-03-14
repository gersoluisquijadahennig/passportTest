<template>

    <div class="q-gutter-y-md" style="max-width: 100%">
        <q-card>
            <q-tabs v-model="tab" dense class="text-grey" active-color="primary" indicator-color="primary"
                align="justify" narrow-indicator>
                <q-tab name="general" label="Datos Generales" />
                <q-tab name="security" label="Seguridad" />
                <q-tab name="miscelaneos" label="Miscelaneos" />
                <q-tab name="contrac" label="Contratos" />
            </q-tabs>

            <q-separator />

            <q-tab-panels v-model="tab" animated>
                <q-tab-panel name="general">
                    <div class="q-pa-md" style="max-width: 400px">
                        <q-form @submit="store" @reset="onReset" class="q-gutter-md">

                            <q-input filled v-model="form.name" label="Nombre *" hint="Nombre del Reino" lazy-rules
                                :rules="[val => val && val.length > 0 || 'la descripcion no puede estar vacia']" />

                            <q-input filled v-model="form.name" label="Segundo Nombre " hint="Nombre del Reino" lazy-rules
                                 />
                            <q-input filled v-model="form.name" label="Apellido Paterno " hint="Nombre del Reino" lazy-rules
                                 />
                            <q-input filled v-model="form.name" label="Apellido Materno " hint="Nombre del Reino" lazy-rules
                                 />



                            <q-input filled v-model="form.email" label="Email *" lazy-rules :rules="[
                                // validar campo correo electronico
                                val => val !== null && val !== '' || 'Introduzca un correo electronico',
                                val => val !== null && val.length > 5 || 'El correo debe tener al menos 5 caracteres',
                                // validar con una expresion regular el correo electronico debe de contener @ y un dominio ssbiobio.cl
                                val => val !== null && val.match(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/) || 'El correo electronico no es valido',
                                //validar que el correo tengo un dominio ssbiobio.cl
                                val => val !== null && val.match(/^[a-zA-Z0-9._-]+@ssbiobio.cl$/) || 'El correo electronico debe tener un dominio ssbiobio.cl'
                            ]
                                " />
                            <q-input filled v-model="form.rut" label="R.u.t *" lazy-rules :rules="[
                                // validar campo rut
                                val => val !== null && val !== '' || 'Introduzca un rut',
                                val => val !== null && val.length > 5 || 'El rut debe tener al menos 5 caracteres',
                                // validar con una expresion regular el rut debe de contener solo numeros y un guion
                                val => val !== null && val.match(/^[0-9]+-[0-9kK]$/) || 'El rut no es valido',
                            ]
                                " />

                            <q-toggle v-model="form.active" label="Estado Activado/Desactivado" />

                            <div>
                                <q-btn label="Guardar" type="submit" color="primary" />
                                <q-btn label="Resetear" type="reset" color="secundary" flat class="q-ml-sm" />
                            </div>
                        </q-form>
                    </div>
                </q-tab-panel>

                <q-tab-panel name="security">
                    <div class="q-pa-md" style="max-width: 400px">
                        <q-input v-model="password" label="Password *" filled :type="isPwd ? 'password' : 'text'" hint="Password">
                            <template v-slot:append>
                            <q-icon
                                :name="isPwd ? 'visibility_off' : 'visibility'"
                                class="cursor-pointer"
                                @click="isPwd = !isPwd"
                            />
                            </template>
                        </q-input>
                    </div>
                    <div class="q-pa-md" style="max-width: 400px">
                        <q-input v-model="repassword" label="Re-Password *" filled :type="isPwd ? 'password' : 'text'" hint="Repetir Password">
                            <template v-slot:append>
                            <q-icon
                                :name="isPwd ? 'visibility_off' : 'visibility'"
                                class="cursor-pointer"
                                @click="isPwd = !isPwd"
                            />
                            </template>
                        </q-input>
                    </div>

                    <div>
                        <q-btn label="Guardar" type="submit" color="primary" />
                        <q-btn label="Resetear" type="reset" color="secundary" flat class="q-ml-sm" />
                    </div>

                </q-tab-panel>

                <q-tab-panel name="miscelaneos">
                    <div class="text-h6">Información Miscelaneos</div>
                </q-tab-panel>

                <q-tab-panel name="contrac">
                    <div class="text-h6">Información de contratos del usuario</div>
                </q-tab-panel>
            </q-tab-panels>
        </q-card>
    </div>




</template>

<script setup>
import { reactive, ref } from 'vue'
import { router } from '@inertiajs/vue3'
import Layout from '@/Layouts/Admin/Layout.vue'
import axios from 'axios';

defineOptions({ layout: Layout })
const props = defineProps({
    realm: {
        type: Object,
        required: true
    }
})

let form = reactive({
    name: null,
    first_name: null,
    last_name: null,
    second_name: null,
    email: null,
    rut: null,
    active: true,
})

const isPwd = ref(true)
const tab = ref('general')

async function store() {
    await axios.post(route('admin.realm.store'), form)
        .then(response => {
            console.log('Realm created', response.data.realm)
            onReset()
        })
        .catch(error => {
            console.error('Error creating realm:', error)
        })
        .finally(() => {
            router.get(route('admin.realm.index'))
        })
}

function onReset() {
    form.name = null
    form.description = null
    form.active = false
}

</script>
