<template>
  <div class="row mt-4">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="card-title">
            <h3>Your Answer</h3>
          </div>
          <hr />
          <form @submit.prevent="create">
            <div class="form-group">
              <textarea
                name="body"
                id=""
                rows="7"
                class="form-control"
                required
                v-model="body"
              >
                            </textarea>
            </div>
            <div class="form-group">
              <button
                type="submit"
                class="btn btn-lg btn-outline-primary"
                :disabled="isInvalid"
              >
                Submit
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["questionId"],
  data() {
    return {
      body: ""
    };
  },
  methods: {
    create() {
      axios
        .post(`/questions/${this.questionId}/answers`, {
          body: this.body
        })
        .then(({ data }) => {
          this.$toast.success(data.message, "Success", {
            position: "topRight"
          });
          this.body = "";
          this.$emit("created", data.answer);
        })
        .catch(err => {
          this.$toast.error(err.response.data.message, "Error", {
            position: "topRight"
          });
        });
    }
  },
  computed: {
    isInvalid() {
      return !this.signedIn || this.body.length < 10;
    }
  }
};
</script>
