<template>
  <div class="bg-white py-24">
    <div class="mx-auto p-10">
      <div class="mx-auto max-w-2xl lg:mx-0">
        <span class="text-medium font-bold tracking-tight text-gray-900 sm:text-4xl">MVPs of the week</span>
      </div>
      <ul role="list" class="mx-auto mt-20 grid max-w-2xl grid-cols-2 gap-y-16 gap-x-8 text-center sm:grid-cols-3 md:grid-cols-4 lg:mx-0 lg:max-w-none lg:grid-cols-5 xl:grid-cols-6">
        <li v-for="person in mvps" :key="person.name">
          <img class="mx-auto h-24 w-24 rounded-full" :src="person.imageUrl" alt="" />
          <h3 class="mt-6 text-base font-semibold leading-7 tracking-tight text-gray-900">{{ person.name }}</h3>
          <p class="text-sm leading-6 text-gray-600">{{ person.role }}</p>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      people: [
        {
          name: 'Michael Foster',
          role: 'Fullstack Developer',
          isMvp: true,
          imageUrl:
              'https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=1024&h=1024&q=80',
        },
        {
          name: 'Kate Smith',
          role: 'DevOps',
          isMvp: false,
          imageUrl:
              'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=1024&h=1024&q=80'
        },
        {
          name: 'Benjamin Russel',
          role: 'Front-end Developer',
          isMvp: true,
          imageUrl:
              'https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=1024&h=1024&q=80'
        },
        {
          name: 'Kristine Watson',
          role: 'Marketing',
          isMvp: false,
          imageUrl:
              'https://images.unsplash.com/photo-1500917293891-ef795e70e1f6?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=1024&h=1024&q=80'
        },
        {
          name: 'Dries Vincent',
          role: 'Junior Developer',
          isMvp: true,
          imageUrl:
              'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=1024&h=1024&q=80'
        },
        {
          name: 'Alicia Bell',
          role: 'Copywriter',
          isMvp: true,
          imageUrl:
              'https://images.unsplash.com/photo-1509783236416-c9ad59bae472?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=1024&h=1024&q=80'
        },
        {
          name: 'Ema Dorsey',
          role: 'Software Engineer',
          isMvp: true,
          imageUrl:
              'https://images.unsplash.com/photo-1505840717430-882ce147ef2d?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=1024&h=1024&q=80'
        },
      ]
    }
  },
  computed: {
    mvps: function () {
      return this.people.filter(function (person) {
        return person.isMvp;
      });
    }
  },
}
</script>