import {Http} from '@/lib/http';

export default {
  async fetchMonitors({commit, getters}, page) {
    try {
      const {data: {monitors, per_page, total}} = await Http.get(
        '/monitors', {
          params: {
            page,
            per_page: getters.getPerPage,
          }
        }
      );

      commit('setMonitors', monitors);
      commit('setPerPage', per_page);
      commit('setTotal', total);
    } catch (e) {
      commit('setMonitors', []);
      throw e;
    }
  },
  async addMonitor({dispatch}, url) {
    await Http.post('/monitors', {url});
    dispatch('fetchMonitors', 1);
  },
  async deleteMonitor({dispatch}, monitor) {
    await Http.delete(`/monitors/${monitor.id}`);
    dispatch('fetchMonitors', 1);
  },
  async manualCheck({}, {checkUptime, checkCertificates}) {
    await Http.post('/monitors/check', {
      check_uptime: checkUptime,
      check_certificates: checkCertificates
    });
  }
}
