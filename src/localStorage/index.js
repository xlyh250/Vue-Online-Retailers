
export default {

    getStorage(storage){
        return JSON.parse(localStorage.getItem(storage)) || []
    },
    setStorage(storage,getItem){
        localStorage.setItem(storage,JSON.stringify(getItem)) 
    }
}