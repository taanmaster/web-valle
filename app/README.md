## Nomenclatura de modulos

### Listado de modulos con sus Abreviaturas
## Última actualización: 11 de marzo de 2026

1. **TSR** = Tesorería (Treasury)
2. **TRN** = Transparencia (Transparency)
3. **DIF** = Desarrollo Integral de la Familia (DIF System)
4. **TAP** = Tesorería Cuentas por Pagar (Treasury Accounts Payable)
5. **IMPLAN** = Instituto Municipal de Planeación (Municipal Planning Institute)
6. **SARE** = Sistema de Atención y Registro de Eventos (Event Attention and Registration System)
7. **URBAN_DEV** = Desarrollo Urbano (Urban Development)
8. **CTO** = Catastro 
9. **SCR** = Secretaria de Ayuntamiento
10. **DINS** = Desarrollo Institucional (Institutional Development)
11. **Environment** = Dirección de Medio Ambiente
12. **FISC** = Fiscalización (Municipal Code Enforcement / Street Commerce Regulation)

### Modelos sin prefijo (Generales del Sistema)
- **Banner** = Banners generales del sistema
- **Blog** = Sistema de blog
- **Citizen** = Ciudadanos y perfiles médicos
- **Event** = Eventos del sistema
- **FinancialSupport** = Apoyo financiero
- **Gazette** = Gaceta municipal
- **Headerband** = Banda de encabezado
- **LegalText** = Textos legales
- **MunicipalRegulation** = Regulaciones municipales
- **Notification** = Notificaciones del sistema
- **Popup** = Ventanas emergentes
- **User** = Usuarios del sistema

### Distribución por Módulo

#### DINS (Desarrollo Institucional)
- **RegulatoryAgenda** = Agenda regulatoria
- **ServiceRequest** = Solicitudes de servicios
- **RegulatoryImpact** = Formatos AIR y Exención

#### DIF (Desarrollo Integral de la Familia)
- DIFConsultType, DIFCoordination, DIFCoordinationProgram
- DIFDoctor, DIFDoctorConsult, DIFLegalProcess
- DIFLocation, DIFLocationAssignment, DIFMedication
- DIFMedicationVariant, DIFPaymentConcept, DIFPrescription
- DIFPrescriptionFile, DIFProgram, DIFReceipt
- DIFReceiptConcept, DIFService, DIFSocialAssistance
- DIFSocioEconomicTest, DIFSocioEconomicTestDependent
- DIFSocioEconomicTestFile, DIFSpecialty, DIFStockMovement

#### TSR (Tesorería)
- TsrAccountDueCustomeReport, TsrAccountDueDailyReport
- TsrAccountDueIncome, TsrAccountDueIncomeReceipt
- TsrAccountDueProfile, TsrAccountDueProvisionalInteger
- TsrAdminRevenueColletionArticle, TsrAdminRevenueColletionClause
- TsrAdminRevenueColletionFraction, TsrAdminRevenueColletionSection
- TsrAdminRevenueColletionVariant, TsrCashier
- TsrRevenueLawConcept, TsrRevenueLawIncome
- TsrRevenueLawRateAndFee

#### TAP (Tesorería Cuentas por Pagar)
- TapChecklistAuthorizationNote, TapSupplierDependency
- TapSupplierLog

#### Treasury (Tesorería - Modelos completos)
- TreasuryAccountPayableChecklist, TreasuryAccountPayableChecklistElement
- TreasuryAccountPayableContractor, TreasuryAccountPayableContractorChecklist
- TreasuryAccountPayableSupplier, TreasuryAccountPayableSupplierChecklist
- TreasuryAccountPayableSupplierChecklistAutorization
- TreasuryAccountPayableSupplierChecklistAutorizationList

#### Transparency (Transparencia)
- TransparencyDependency, TransparencyDependencyUser
- TransparencyDocument, TransparencyFile
- TransparencyObligation

#### IMPLAN (Instituto Municipal de Planeación)
- ImplanAchievement, ImplanBanner, ImplanBlog, ImplanProject

#### SARE (Sistema de Atención y Registro)
- SareRequest, SareRequestFile, SareRequestNote

#### URBAN_DEV (Desarrollo Urbano)
- UrbanDevRequest, UrbanDevRequestFile, UrbanDevRequestNote
- UrbanDevWorker, UrbanDevCost, UrbanDevFormat, UrbanDevCastroRequest
- UrbanDevRequestReview (dictámenes enviados a Protección Civil / Medio Ambiente, tabla `urban_dev_request_reviews`,
  columna `dependency`; ver `SareRequestReview` para el mismo patrón aplicado a SARE → Desarrollo Urbano).
  Protección Civil no es un módulo aparte: su bandeja (`proteccion_civil.requests.*`) vive bajo el sidebar de
  Desarrollo Urbano (rol `urban_dev`), igual que "Solicitudes SARE".

#### Environment (Dirección de Medio Ambiente)
- EnvironmentRequest, EnvironmentRequestFile, EnvironmentRequestNote
- EnvironmentEvent
- EnvironmentDeliveryVoucher, EnvironmentDeliveryVoucherItem
- Bandeja de solicitudes de Desarrollo Urbano (Visto Bueno Ambiental) usa el modelo `UrbanDevRequestReview` con
  `dependency = 'medio_ambiente'`, no un modelo propio

#### FISC (Fiscalización)
- FiscStreetVendingRequest, FiscStreetVendingRequestFile
- FiscPublicEventRequest, FiscPublicEventRequestFile
- FiscPrivateEventRequest, FiscPrivateEventRequestFile
- FiscAdvertisingRequest, FiscAdvertisingRequestFile
- FiscWorker (directorio de personal, tabla `fisc_workers`)