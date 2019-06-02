import axios from 'axios'

export default function ajax(url, data={},type="get") {

    if (type == 'get') {
            for (const key in data) {
                if (data[key]) {
                    var s = url.indexOf('?');
                    url = s === -1 ? url + '?' + key + '=' + data[key] + '&' : url + key + '=' + data[key] + '&';
                }
            }

            if (url.indexOf('?') > -1) {
                url = url.slice(0, url.lastIndexOf('&'));
            }
    }
  
    return new Promise((resolve,reject) => {
        let promise;
        
        promise = type == 'get' ? axios.get(url) : axios.post(url, data);

        promise.then(function (response) {
            // 成功了调用resolve()
            resolve(response.data)
        }).catch(error => {
            //失败了调用reject()
            console.log(error);
            
            resolve(error.response.data)
        })
        
    })
}

// data:{
// a: this.global.a,
    // b: this.global.b,
//   }

//