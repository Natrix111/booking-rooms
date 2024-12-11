<template>
  <Form
      @submit="submitForm"
      :validation-schema="registrationSchema"
      class="space-y-6">
    <div>
      <label for="avatar">Аватар пользователя</label>
      <input
          id="avatar"
          type="file"
          accept="image/jpeg, image/png"
          @change="handleAvatarUpload"
          class="input"
      />
      <p class="text-sm text-gray-500 mt-1">Файл формата jpeg, png, размером не более 2 МБ</p>
      <p v-if="avatar.error" class="error">{{ avatar.error }}</p>
      <div v-if="avatar.preview" class="mt-4">
        <img
            :src="avatar.preview"
            alt="Avatar Preview"
            class="w-20 h-20 object-cover rounded" />
      </div>
    </div>

    <div>
      <label for="name">Ваше имя</label>
      <Field
          id="name"
          name="name"
          type="text"
          placeholder="Ваше имя"
          class="input"
      />
      <ErrorMessage name="name" class="error" />
    </div>

    <div>
      <label for="phone">Телефон</label>
      <Field
          id="phone"
          name="phone"
          type="text"
          v-imask="{mask: '+{7}(000)000-00-00'}"
          value="+7"
          placeholder="+7(XXX)XXX-XX-XX"
          class="input"
      />
      <ErrorMessage name="phone" class="error" />
    </div>

    <div>
      <label for="email">E-mail</label>
      <Field
          id="email"
          name="email"
          type="email"
          placeholder="example@email.com"
          class="input"
      />
      <ErrorMessage name="email" class="error" />
    </div>

    <div>
      <label for="password">Пароль</label>
      <Field
          id="password"
          name="password"
          type="password"
          placeholder="Введите пароль"
          class="input"
      />
      <ErrorMessage name="password" class="error" />
    </div>

    <div v-if="Object.keys(errorsFromApi).length > 0">
      <p v-for="error in errorsFromApi" class="error">{{ error[0] }}</p>
    </div>

    <div class="flex space-x-4 items-center">
      <my-button class="button-blue">Зарегистрироваться</my-button>
      <my-button type="reset" class="button-grey">Сбросить</my-button>
      <LoadSpinner v-if="isLoading"/>
    </div>
  </Form>
</template>

<script setup>
import { ref } from "vue"
import { Form, Field, ErrorMessage } from "vee-validate"
import { object, string } from "yup"
import LoadSpinner from "@/components/UI/LoadSpinner.vue";
import MyButton from "@/components/UI/MyButton.vue";
import {useAuthStore} from '@/stores/auth-store';

const {register} = useAuthStore();

const isLoading = ref(false);
const errorsFromApi = ref([])

const avatar = ref({
  avatar: null,
  preview: null,
  error: '',
})

const registrationSchema = object({
  name: string()
      .matches(/^[А-Яа-яЁё\s.-]+$/, "Имя должно содержать только кириллицу, пробелы, точки или тире")
      .required("Имя обязательно"),
  phone: string()
      .matches(/^\+7\(\d{3}\)\d{3}-\d{2}-\d{2}$/, "Номер телефона должен быть в формате +7(XXX)XXX-XX-XX")
      .required("Телефон обязателен"),
  email: string()
      .email("Введите корректный e-mail")
      .required("E-mail обязателен"),
  password: string()
      .required("Пароль обязателен")
      .min(8, "Пароль должен содержать минимум 8 символов")
      .matches(/^[A-Za-z0-9!@#$%^&*()_+=-]+$/, "Пароль содержит недопустимые символы")
})

const handleAvatarUpload = (event) => {
  const file = event.target.files[0]

  if (file && file.size <= 2 * 1024 * 1024 && ["image/jpeg", "image/png"].includes(file.type)) {
    avatar.value.avatar = file
    avatar.value.preview = URL.createObjectURL(file)
    avatar.value.error = ""
  } else {
    avatar.value.avatar = null
    avatar.value.preview = null
    avatar.value.error = "Файл должен быть формата jpeg, png и размером не более 2 МБ."
  }
}

const submitForm = async (values) => {
  try {
    if(avatar.value.error) return

    isLoading.value = true

    const formData = new FormData()
    avatar.value.avatar ? formData.append("avatar", avatar.value.avatar) : null
    formData.append("name", values.name)
    formData.append("phone", values.phone)
    formData.append("email", values.email)
    formData.append("password", values.password)

    await register(formData)

  } catch (error) {
    console.error(error)
    errorsFromApi.value = error.response.data
  } finally {
    isLoading.value = false
  }
}
</script>

<style scoped>

label {
  @apply block mb-2
}

.error {
  @apply text-red-500 text-sm mt-1
}
</style>