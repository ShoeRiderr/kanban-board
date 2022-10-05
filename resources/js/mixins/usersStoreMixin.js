import { users } from '@/store/users';

export default {
  setup() {
    const store = users();

    return {
      store,
    }
  },
}
