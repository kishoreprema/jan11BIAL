��          �   %   �      0     1     >     T  ;   a     �     �     �     �     �     �     �     �          
     (     8     E    W     k  �   z  �   P  K   *  B  v  5  �     �	      
     
  C   /
     s
     �
     �
     �
     �
     �
  	   �
     �
  
   �
               +     ?  �  W     T  �   d  �   8  6     c  C                                                                                      
                  	                       Add CallerID Add CallerID Instance Add Variable Adds the ability to change the CallerID within a call flow. Applications CallerID Name CallerID Number Delete Description Destination Edit Edit CallerID Instance Edit:  Invalid description specified Other Variables Set CallerID Set CallerID %s:  Set CallerID allows you to change the caller id of the call and then continue on to the desired destination. For example, you may want to change the caller id form "John Doe" to "Sales: John Doe". Please note, the text you enter is what the callerid is changed to. To append to the current callerid, use the proper asterisk variables, such as "${CALLERID(name)}" for the currently set callerid name and "${CALLERID(num)}" for the currently set callerid number. You may also set any number of additional channel variables from here. Submit Changes The CallerID Name that you want to change to. If you are appending to the current callerid, dont forget to include the appropriate asterisk variables. If you leave this box blank, the CallerID name will be blanked The CallerID Number that you want to change to. If you are appending to the current callerid, dont forget to include the appropriate asterisk variables. If you leave this box blank, the CallerID number will be blanked The descriptive name of this CallerID instance. For example "new name here" You may set any other variables that will be set for the channel, with any name and value you want, as using Set() directly from the dialplan. They should be entered as:<br /> [variable] = [value]<br /> in the boxes below. Click the Add Variable box to add additional variables. Blank boxes will be deleted when submitted. Project-Id-Version: PACKAGE VERSION
Report-Msgid-Bugs-To: 
POT-Creation-Date: 2011-09-23 09:52+0000
PO-Revision-Date: YEAR-MO-DA HO:MI+ZONE
Last-Translator: FULL NAME <EMAIL@ADDRESS>
Language-Team: LANGUAGE <LL@li.org>
MIME-Version: 1.0
Content-Type: text/plain; charset=utf-8
Content-Transfer-Encoding: 8bit
 Añadir CallerID Añadir Instancia de CallerID Añadir Variable Permite cambiar el identificador (CallerID) en un flujo de llamada. Aplicaciones Nombre de Identificador Número de Identificador Eliminar Descripción Destino Modificar Modificar Instancia de CallerID Modificar: Descripción Inválida Otras Variables Establecer CallerID Establecer CallerID %s: Establecer CallerID le permite cambiar el identificador de llamadas y luego continuar al destino deseado. Por ejemplo, puede cambiar el identificador de "Juan Perez" a "Ventas: Juan Perez". Tenga en cuenta que el texto que ingrese será el utilizado para la identificación. Si desea añadir al CallerID existente, puede usar variables como ser "${CALLERID(name)}" para el nombre de identificación actual, o "${CALLERID(num)}" para el número.También puede establecer variables de canal desde este módulo. Guardar Cambios El nombre de CallerID que desee cambiar. Si desea añadir al existente, no olvide incluir la variable correspondiente "${CALLERID(name)}". Si deja esto en blanco entonces el identifcador de nombre será vaciado. El número de CallerID que desee cambiar. Si desea añadir al existente, no olvide incluir la variable correspondiente "${CALLERID(num)}". Si deja esto en blanco entonces el identifcador de nombre será vaciado. Un nombre descriptivo para esta instancia de CallerID. Puede configurar cualquier variable de canal, con cualquier nombre y valor, del mismo modo que usaría la aplicación Set() en el plan de marcado. Deben ser ingresadas como:<br /> [variable] = [valor]<br /> en los casilleros abajo. Pulse en Añadir Variable para agregar variables adicionales. Si las deja en blanco serán elimiadas al enviar los cambios. 