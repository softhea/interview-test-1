<template>
  <div>
    <div class="p-10">
      <h1 class="text-4xl font-bold">Candidates</h1>
    </div>
    <div class="p-10 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 gap-5">
      <div v-for="candidate in listedCandidates" class="rounded overflow-hidden shadow-lg" v-show="!candidate.knows_wordpress">
        <img class="w-full" src="/avatar.png" alt="">
        <div class="px-6 py-4">
          <div class="font-bold text-xl mb-2">{{candidate.name}}</div><p class="text-gray-700 text-base">{{candidate.description}}</p>
        </div>
        <div class="px-6 pt-4 pb-2">
          <span v-for="strength in candidate.strengths" 
            class="inline-block bg-gray-200  rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2"
            v-bind:class = "getBackgroundColor(desiredStrengths.includes(strength))"
            >{{strength}}</span>
        </div>
        <div class="px-6 pb-2">
          <span v-for="skill in candidate.soft_skills" 
            class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2"
            v-bind:class = "getBackgroundColor(desiredSoftSkills.includes(skill))"
            >{{skill}}
          </span>
        </div>
        <div class="px-6 pt-4 pb-2" v-show="candidate.is_hired">
          <span 
            class="inline-block bg-red-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2"
          >Is Hired</span>
        </div>
        <div class="p-6 float-right">
          <button 
            class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow"
            @click="contact(candidate.id)"
          >Contact</button>
          <button 
            class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 hover:bg-teal-100 rounded shadow"
            v-show="candidate.can_be_hired"
            @click="hire(candidate.id)"
          >Hire</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['candidates', 'desiredSoftSkills'],
  data() {
    return {
      desiredStrengths: [
        'Vue.js', 'Laravel', 'PHP', 'TailwindCSS'
      ],
      listedCandidates: this.candidates,
    }
  },
  created() {
    this.listedCandidates.forEach(candidate => {
      candidate.soft_skills = JSON.parse(candidate.soft_skills);
      candidate.strengths = JSON.parse(candidate.strengths);

      candidate.knows_wordpress = candidate.strengths.includes('Wordpress');
    });
  },
  methods: {
    getBackgroundColor(highlighted) {
      return highlighted ? 'bg-green-300' : 'bg-gray-200';
    },
    contact(id) {
      axios.patch('/candidates/' + id + '/contact')
        .then(response => {
          alert(response.data.message);

          let candidateIndex = this.listedCandidates.findIndex((obj => obj.id == id));
          this.listedCandidates[candidateIndex].can_be_hired = true;

          document.getElementById('no-of-coins').textContent = response.data.coins;
        })
        .catch(function (error) {
          if (error.response) {
            alert(error.response.data.error);
          }
        });
    },
    hire(id) {
      axios.patch('/candidates/' + id + '/hire')
        .then(response => {
          alert(response.data.message);

          let candidateIndex = this.listedCandidates.findIndex((obj => obj.id == id));
          this.listedCandidates[candidateIndex].is_hired = true;
          this.listedCandidates[candidateIndex].can_be_hired = false;

          document.getElementById('no-of-coins').textContent = response.data.coins;
        })
        .catch(function (error) {
          if (error.response) {
            alert(error.response.data.error);
          }
        });
    },
  },
}
</script>