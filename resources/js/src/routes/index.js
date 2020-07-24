import { roomRoutes } from './room';

let routes = [
    {
        name: 'welcome',
        path: '/'
    }
];

routes = routes.concat(roomRoutes);

export default routes;
