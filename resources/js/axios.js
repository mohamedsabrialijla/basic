import axios from 'axios';
import router from './routes';

axios.defaults.baseURL = 'http://127.0.0.1:8000/web/';
// axios.defaults.baseURL = 'https://z98.c92.mytemp.website/web/';

axios.defaults.headers.common['authorization'] = 'Bearer ' + localStorage.getItem('token') ;


// اعتراض استجابات Axios
axios.interceptors.response.use(
  (response) => {
    return response;
  },
  (error) => {
    // التحقق من حالة الخطأ إذا كانت تشير إلى انتهاء الجلسة
    if (error.response && error.response.status === 401) {
      // إعادة توجيه المستخدم إلى صفحة تسجيل الدخول
       // router.push({ path: `/${localStorage.getItem('locale')}/login` });

    	let url = window.location.origin ;
        window.open(url+'/login',"_self")
    }
    return Promise.reject(error);
  }
);