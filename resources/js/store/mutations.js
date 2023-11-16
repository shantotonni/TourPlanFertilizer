export const mutations = {
    submitButtonLoadingStatus(state, payload) {
        state.isSubmitButtonLoading = payload
    },
    supportingData(state, payload) {
    },
    me(state, payload) {
        state.me = payload
    },
    eStatement(state, payload) {
        state.eStatement = payload
    },
}
