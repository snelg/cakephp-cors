<?php
namespace Cors\Routing\Filter;

use Cake\Event\Event;
use Cake\Routing\DispatcherFilter;

class CorsFilter extends DispatcherFilter
{
    public function beforeDispatch(Event $e)
    {
        $request = $e->data['request'];
        $controller = $request->param('controller');
        $action = $request->param('action');
        $handledRoutes = $this->config('routes');
        $corsOptions = $this->request->param('cors');

        // Conditional to run our CORS headers on response if set in Router::connect()
        if ($corsOptions) {
            // Set our arguments based on defaults vs. provided
            $origin = (!empty($corsOptions['origin'])) ? $corsOptions['origin'] : '*';
            $methods = (!empty($corsOptions['methods'])) ? $corsOptions['methods'] : [];
            $headers = (!empty($corsOptions['headers'])) ? $corsOptions['headers'] : [];

            // Set the CORS headers on our response based on input arguments
            return $e->data['response']->cors($request, $origin, $methods, $headers);
        }

        if (empty($handledRoutes[$controller])) {
            //Might be numeric-keyed single entry
            if (is_array($handledRoutes) && in_array($controller, $handledRoutes)) {
                $handledRoutes[$controller] = ['*'];
            } else {
                return;
            }
        }
        
        if (!is_array($handledRoutes[$controller])) {
            //Single actions can be a string
            $handledRoutes[$controller] = [$handledRoutes[$controller]];
        }
        
        if (empty($handledRoutes[$controller][$action]) &&
                !in_array($action, $handledRoutes[$controller]) && 
                !in_array('*', $handledRoutes[$controller])) {
            //Not this action
            return;
        }

        $origin = '*';
        $methods = [];
        $headers = [];

        if (!empty($handledRoutes[$controller][$action])) {
            $params = $handledRoutes[$controller][$action];
            if (!empty($params['origin'])) {
                $origin = $params['origin'];
            }
            if (!empty($params['methods'])) {
                $methods = $params['methods'];
            }
            if (!empty($params['headers'])) {
                $headers = $params['headers'];
            }
        }
        
        $e->data['response']->cors($request, $origin, $methods, $headers);
    }

    protected function _controllerize($controllerName)
    {

    }
}
