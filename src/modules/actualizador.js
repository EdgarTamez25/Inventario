import Vue from 'vue'

export default{
	namespaced: true,
	state:{
		InventarioArticulos : [],
	},

	mutations:{
		//actualiza los articulos con la informacion que le manda el action
		ARTICULOS(state, payload){
			state.InventarioArticulos = payload
		},
	},
	actions:{		
		// this.$http.get('articulos').then((response)=>{
		// 	console.log('respone', response.body)
		// 	// this.articulos = response.body
		// 	this.actualizaArticulos(response.body)
	
		//   })
		consultarArticulos({commit}){
			Vue.http.get('articulos').then((response)=>{
				commit('ARTICULOS', response.body)
			}).catch((error) =>{
				console.log(error)
			})
		},

		actualizaArticulos({commit}, payload){
			commit('ARTICULOS', payload)
			return true
		},

	},

	getters:{
		//trae la información de usuario despues de haber sido mutada
		getArticulos(state){
			return state.InventarioArticulos
		},
	}
}
