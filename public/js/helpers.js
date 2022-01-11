//import { async } from 'regenerator-runtime';
import { TIMEOUT_SEC } from './config.js';



export const GETAJAX = async function (url ) {
 
    try {
        let res = await fetch(url, {
            method: 'GET',
            headers: {
              'Content-Type': 'application/json',
              "X-CSRF-Token": document.querySelector('input[name=_token]').value
            },
          
          });

        return await res.text();
    } catch (error) {
        console.log(error);
    }

};

export const POSTAJAX = async function (url, data ) {
 
  try {
      let res = await fetch(url, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            "X-CSRF-Token": document.querySelector('input[name=_token]').value
          },
          body: JSON.stringify(data)
        });

      return await res.text();
  } catch (error) {
      console.log(error);
  }

};