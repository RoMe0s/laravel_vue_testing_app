<template>
    <div class="flex flex-col">
        <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
            <div class="align-middle inline-block min-w-full overflow-hidden">
                <table class="min-w-full mb-6" v-if="monitorsExist">
                    <thead>
                    <tr>
                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Url
                        </th>
                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Last check
                        </th>
                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Certificate status
                        </th>
                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white">
                    <tr v-for="(monitor, index) in monitors" :key="index">
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                            {{ monitor.url }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                            {{ monitor.last_checked_at || 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                            {{ monitor.status }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                            {{ monitor.certificate_status }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium">
                            <button @click="monitorToRemove = monitor"
                                    class="bg-red-300 hover:bg-red-300 text-gray-800 font-bold py-2 px-4 rounded-l rounded-r">
                                Delete
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <pagination :page="page" :per-page="perPage" :total="total" @page-changed="changePage"
                            v-if="total > perPage"></pagination>

                <div class="flex">
                    <div class="w-1/2">
                        <button class="bg-green-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-l rounded-r"
                                @click="showAddMonitorModal = !showAddMonitorModal">
                            Add Site
                        </button>
                    </div>
                    <div class="w-1/2 text-right" v-if="monitorsExist">
                        <button @click="checkMonitors(true, true)"
                                class="bg-purple-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-l">
                            Check All
                        </button>
                        <button @click="checkMonitors(true, false)"
                                class="bg-blue-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4">
                            Check Uptime
                        </button>
                        <button @click="checkMonitors(false, true)"
                                class="bg-yellow-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-r">
                            Check Certificate
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <add-monitor-modal v-show="showAddMonitorModal" @close="showAddMonitorModal = false"></add-monitor-modal>
        <remove-monitor-modal v-show="!(monitorToRemove === null)" :monitor="monitorToRemove"
                              @close="monitorToRemove = null"></remove-monitor-modal>
    </div>
</template>
<script>
  import {mapGetters, mapActions} from 'vuex';
  import AddMonitorModal from '@/components/AddMonitorModal.vue';
  import RemoveMonitorModal from '@/components/RemoveMonitorModal.vue';
  import Pagination from '@/components/Pagination.vue';
  import {socket} from '@/lib/socket';
  import {toastr} from '@/lib/toastr';

  export default {
    components: {
      AddMonitorModal,
      RemoveMonitorModal,
      Pagination
    },
    data() {
      return {
        showAddMonitorModal: false,
        monitorToRemove: null,
        page: 1
      }
    },
    computed: {
      monitorsExist: function () {
        return this.monitors.length > 0;
      },
      ...mapGetters({
        monitors: 'monitors/getMonitors',
        perPage: 'monitors/getPerPage',
        total: 'monitors/getTotal',
      })
    },
    methods: {
      ...mapActions({
        fetchMonitors: 'monitors/fetchMonitors',
        manualCheck: 'monitors/manualCheck',
      }),
      async changePage(page) {
        await this.fetchMonitors(page);
        this.page = page;
      },
      checkMonitors(checkUptime, checkCertificates) {
        this.manualCheck({checkUptime, checkCertificates});
      }
    },
    created() {
      socket.private('monitors')
        .listen('Monitor.MonitorsUptimeUpdatedEvent', () => toastr.info('Uptime check successfully finished!'))
        .listen('Monitor.MonitorsCertificatesUpdatedEvent', () => toastr.info('Certificates check successfully finished!'))
        .listen('Monitor.MonitorsUpdatedEvent', () => this.fetchMonitors(this.page));

      this.changePage(this.page);
    }
  }
</script>
