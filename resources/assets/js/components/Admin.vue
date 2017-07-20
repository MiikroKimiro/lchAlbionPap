<template>
<div class="container">
  <mu-table ref="table" :selectable="false" :showCheckbox="false">
    <mu-thead>
      <mu-tr>
        <mu-th>Name</mu-th>
        <mu-th>Email</mu-th>
        <mu-th>Cree</mu-th>
        <mu-th>Admin</mu-th>
        <mu-th>Officer</mu-th>
        <mu-th>Verified</mu-th>
      </mu-tr>
    </mu-thead>
    <mu-tbody>
      <mu-tr v-for="user, key in users" :key="key">
        <mu-td>{{user.name}}</mu-td>
        <mu-td>{{user.email}}</mu-td>
        <mu-td>{{user.created_at}}</mu-td>
        <mu-td>
            <mu-checkbox :value="user.isAdmin" @change="admin(user.id)"/>
        </mu-td>
        <mu-td>
            <mu-checkbox :value="user.isOfficer" @change="officer(user.id)"/>
        </mu-td>
        <mu-td>
            <mu-checkbox :value="user.verified" @change="verified(user.id)"/>
        </mu-td>
      </mu-tr>
    </mu-tbody>
  </mu-table>
</div>
</template>
<script>
export default {
  data () {
    return {
      users: {}
    }
  },
  mounted () {
    this.getUsers()
  },
  methods: {
    getUsers () {
      axios.get('/admin/index')
        .then(({data}) => {
          this.users = data
        })
    },
    admin (userId) {
      axios({
        url: '/admin/' + userId + '/makeAdmin',
        method: 'patch'
      }).then(() => {
        this.getUsers()
      })
    },
    officer (userId) {
      axios({
        url: '/admin/' + userId + '/makeOfficer',
        method: 'patch'
      }).then(() => {
        this.getUsers()
      })
    },
    verify (userId) {
      axios({
        url: '/admin/' + userId + '/verify',
        method: 'patch'
      }).then(() => {
        this.getUsers()
      })
    }
  }
}
</script>