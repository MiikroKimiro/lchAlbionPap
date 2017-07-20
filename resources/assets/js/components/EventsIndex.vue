<template>
  <div class="container">
    <mu-card>
      <mu-card-header title="Events"/>
      <mu-card-text>
        <mu-table :selectable="false" :showCheckbox="false" ref="table">
          <mu-thead>
            <mu-tr>
              <mu-th>Date (UTC)</mu-th>
              <mu-th>Lead</mu-th>
              <mu-th>Name</mu-th>
              <mu-th>Type</mu-th>
              <mu-th>Comment</mu-th>
              <mu-th>Participants</mu-th>
              <mu-th>Link</mu-th>
            </mu-tr>
          </mu-thead>
          <mu-tbody>
            <mu-tr v-for="event, key in events" :key="key">
              <mu-td>{{ event.created_at }}</mu-td>
              <mu-td>{{ event.lead_name }}</mu-td>
              <mu-td>{{ event.name }}</mu-td>
              <mu-td>{{ event.type }}</mu-td>
              <mu-td>{{ event.comment }}</mu-td>
              <mu-td>{{ event.participants_count }}</mu-td>
              <mu-td>
                <a :href="event.pap_link " v-if="event.status === 'open' ">Link</a>
                <template v-else>Closed</template>
              </mu-td>
            </mu-tr>
          </mu-tbody>
        </mu-table>
      </mu-card-text>
    </mu-card>
    <mu-card class="mt-4">
      <mu-card-header title="New Event"/>
      <mu-card-text>
        <mu-text-field label="Name" v-model="newEvent.name" fullWidth required/>
        <br/>
        <mu-select-field v-model="newEvent.type" label="Type" fullWidth >
          <mu-menu-item value="convoi" title="Convoi"/>
          <mu-menu-item value="warcamp" title="Warcamp"/>
          <mu-menu-item value="autre" title="Autre"/>
        </mu-select-field>
        <br/>
        <mu-text-field label="Comment" multiLine v-model="newEvent.comment" fullWidth/>
        <br/>
      </mu-card-text>
      <mu-card-actions>
        <mu-flat-button label="Submit" @click="submitNewEvent"/>
      </mu-card-actions>
    </mu-card>
    <mu-dialog :open="dialog" title="Dialog" @close="close">
      Succes<br>
      Partager ce lien aux participants: <a :href="newEventHref">Lien a partager</a>
      <mu-flat-button slot="actions" @click="close" primary label="Close"/>
    </mu-dialog>
    <mu-card class="mt-4">
      <mu-card-header title="Moins de participations ce mois"/>
      <mu-card-text>
        <mu-table :selectable="false" :showCheckbox="false" ref="table">
          <mu-thead>
            <mu-tr>
              <mu-th>Nom</mu-th>
              <mu-th>Participations</mu-th>
            </mu-tr>
          </mu-thead>
          <mu-tbody>
            <mu-tr v-for="user, key in thisMonthBad" :key="key">
              <mu-td>{{ user.name }}</mu-td>
              <mu-td>{{ user.this_month_participations_count }}</mu-td>
            </mu-tr>
          </mu-tbody>
        </mu-table>
      </mu-card-text>
    </mu-card>
    <mu-card class="mt-4">
      <mu-card-header title="Moins de participations mois dernier"/>
      <mu-card-text>
        <mu-table :selectable="false" :showCheckbox="false" ref="table">
          <mu-thead>
            <mu-tr>
              <mu-th>Nom</mu-th>
              <mu-th>Participations</mu-th>
            </mu-tr>
          </mu-thead>
          <mu-tbody>
            <mu-tr v-for="user, key in lastMonthBad" :key="key">
              <mu-td>{{ user.name }}</mu-td>
              <mu-td>{{ user.last_month_participations_count }}</mu-td>
            </mu-tr>
          </mu-tbody>
        </mu-table>
      </mu-card-text>
    </mu-card>
  </div>
</template>
<script>
    export default{
        data(){
            return{
                events: {},
                thisMonthBad: {},
                lastMonthBad: {},
                newEvent: {
                  name: '',
                  type: 'convoi',
                  comment: ''
                },
                newEventHref: '',
                dialog: false
            }
        },
        mounted() {
          this.getEvents()
        },
        methods: {
            getEvents() {
              axios.get('/events/index')
                .then(({data}) => {
                    this.events = JSON.parse(data.events)
                    this.thisMonthBad = JSON.parse(data.thisMonthBad)
                    this.lastMonthBad = JSON.parse(data.lastMonthBad)
                })
            },
            submitNewEvent() {
              axios({
                url: '/events',
                method: 'POST',
                data: this.newEvent
              }).then((response) => {
                this.dialog = true
                this.newEventHref = response.data
                this.getEvents()
              })
            },
            close () {
                this.dialog = false
            }
        }
    }


</script>
