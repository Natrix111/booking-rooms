<template>
  <main>
    <section v-if="isAuth">
      <h2 class="text-center">Вы уже авторизованы</h2>
    </section>
    <section v-if="!isAuth">
      <h2 class="text-center">Регистрация</h2>
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
          <p v-if="avatarError" class="error">{{ avatarError }}</p>
          <div v-if="avatarPreview" class="mt-4">
            <img
                :src="avatarPreview"
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
              v-mask="'+7(###)###-##-##'"
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

        <div class="flex space-x-4">
          <button type="submit" class="button button-blue">Зарегистрироваться</button>
          <button type="reset" class="button button-grey">Сбросить</button>
        </div>
      </Form>
    </section>
  </main>
</template>

<script setup>
import { ref } from "vue"
import { Form, Field, ErrorMessage } from "vee-validate"
import { object, string } from "yup"
import {useAuthStore} from '@/stores/auth-store';
import {storeToRefs} from "pinia";

const {isAuth} = storeToRefs(useAuthStore());
const {register} = useAuthStore();

const avatar = ref(null)
const avatarPreview = ref(null)
const avatarError = ref("")

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
    avatar.value = file
    avatarPreview.value = URL.createObjectURL(file)
    avatarError.value = ""
  } else {
    avatar.value = null
    avatarPreview.value = null
    avatarError.value = "Файл должен быть формата jpeg, png и размером не более 2 МБ."
  }
}

const submitForm = (values) => {
  try {
    if(avatarError.value) return

    const formData = new FormData()
    avatar.value ? formData.append("avatar", avatar.value) : null
    formData.append("name", values.name)
    formData.append("phone", values.phone)
    formData.append("email", values.email)
    formData.append("password", values.password)

    register(formData)

  } catch (error) {
    console.error(error)
  }
}
</script>

<style scoped>
section {
  @apply bg-white shadow-lg p-6;
}

label {
  @apply block mb-2
}

.error {
  @apply text-red-500 text-sm mt-1
}
</style>
