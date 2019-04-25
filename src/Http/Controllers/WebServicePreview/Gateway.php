<?php

namespace Larangular\WebServicePreview\Http\Controllers\WebServicePreview;

use Larangular\RoutingController\{Controller,
    Contracts\HasPagination,
    Contracts\HasResource,
    Contracts\IGatewayModel,
    Contracts\RecursiveStoreable,
    RecursiveStore\RecursiveOption};

use Larangular\WebServiceManager\Facades\ServiceRequest;
use Larangular\WebServiceManager\Register\ServiceDescriptor;
use Larangular\WebServiceManager\Register\ServiceRecords;
use Msd\WebServiceLogger\Models\WebServiceLog;
use Msd\WebServiceLogger\Http\Resources\WebServiceLogResource;


use Illuminate\Http\Request;
use Msd\Sura\Autoclick\Cotiza\{Oferta, OfertaBase, OfertaBaseRequest, ProductoBase, ProductoRequest, Producto};
use Msd\Sura\Autoclick\Detalle\{Detalle, DetalleProducto, DetalleRequest};

use Msd\Sura\Autoclick\Generar\{Cotizacion, CotizacionRequest, Poliza, PolizaRequest};

use Msd\Sura\Autoclick\Models\ServiceForm;
use Psy\Util\Str;
use \Sura\Autoclick\{ServiceType, StructType, EnumType, ClassMap};
use Larangular\WebServiceManager\Register\Service;
use Larangular\WebServiceManager\Traits\ServiceUrl;


class Gateway {

    use ServiceUrl;
    private $serviceDescription;
    private $routePrefix = 'larangular.webservice-preview.';
    private $serviceRecords;
    private $selectedServiceKeys;

    public function __construct(ServiceRecords $serviceRecords) {
        $this->serviceRecords = $serviceRecords;
        $this->setDefaultSelection();
        //$this->serviceDescription = new ServicesDescription();
    }

    public function getServiceForm(string $provider, string $service) {
        $serviceData = $this->serviceDescription->getServiceDescription($serviceName);
        $serviceForm = new ServiceForm([
            'service' => $serviceData,
            'form'    => $this->getForm($serviceData),
        ]);

        return $serviceForm;
    }

    public function index() {
        return redirect(route($this->routePrefix . 'service.form', $this->selectedServiceKeys));
    }

    public function show(string $provider, ?string $service = null) {
        $this->setSelectedServiceKeys($provider, $service);
        if (is_null($service) || empty($service)) {
            return $this->index();
        }

        return view('larangular.web-service-preview::index', $this->getViewData());
    }

    public function serviceResponse(Request $request, string $provider, string $service) {
        $this->setSelectedServiceKeys($provider, $service);
        $data = $this->getViewData();
        $data['response'] = ServiceRequest::getRequestableWithServiceNames($provider, $service, $request->all(), false)
                                          ->getResponse();

        return view('larangular.web-service-preview::index', $data);
    }

    public function makeRequest($service, $data) {
        $serviceData = $this->serviceDescription->getServiceDescription($service);
        $serviceInstance = $this->getServiceInstance($serviceData, $data);
        return $serviceInstance->getResponse();
    }

    private function setDefaultSelection(): void {
        $provider = array_first($this->serviceRecords->getProviders());
        $this->setSelectedServiceKeys($provider, array_first($this->serviceRecords->getServiceNames($provider)));
    }

    private function setSelectedServiceKeys(string $provider, ?string $service = null): void {
        if (is_null($service) || empty($service)) {
            $service = array_first($this->serviceRecords->getServiceNames($provider));
        }

        $this->selectedServiceKeys = [
            'provider' => $provider,
            'service'  => $service,
        ];
    }

    private function getViewData(): array {
        $descriptor = $this->getDescriptor();
        $serviceUrl = $this->getServiceUrl($descriptor->provider(), $descriptor->serviceName());
        return [
            'service_url' => $serviceUrl,
            'providers'   => $this->getProviderRoutes(),
            'services'    => $this->getServiceRoutes(),
            'selection'   => $this->selectedServiceKeys,
            'form'        => $this->getForm(),
            'descriptor'  => $descriptor,
        ];
    }

    private function getForm(): array {
        return [
            'action' => route($this->routePrefix . 'service.response', $this->selectedServiceKeys),
            'fields' => $this->getDescriptor()
                             ->getForm(),
        ];
    }

    private function getDescriptor(): ServiceDescriptor {
        return $this->serviceRecords->getService($this->selectedServiceKeys['provider'],
            $this->selectedServiceKeys['service']);
    }

    private function getProviderRoutes() {
        $providers = $this->serviceRecords->getProviders();
        $response = [];
        foreach ($providers as $provider) {
            $response[] = [
                'route'  => 'larangular.webservice-preview.service.form',
                'name'   => $provider,
                'params' => [
                    'provider' => $provider,
                    'service'  => null,
                ],
            ];
        }

        return $response;
    }

    private function getServiceRoutes() {
        $services = $this->serviceRecords->getServiceNames($this->selectedServiceKeys['provider']);
        $response = [];
        foreach ($services as $service) {
            $response[] = [
                'route'  => 'larangular.webservice-preview.service.form',
                'name'   => $service,
                'params' => [
                    'provider' => $this->selectedServiceKeys['provider'],
                    'service'  => $service,
                ],
            ];
        }

        return $response;
    }
}
