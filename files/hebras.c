#include <pthread.h>
#include <stdio.h>
#include <stdlib.h>
#include <time.h>


void *sum_arreglo_func(void *arreglo)
{
	int i;
	void* sum = 0;
	for(i = 1; i <= ((int *)(arreglo))[0]; i++){
		sum += ((int *)(arreglo))[i];
	}
	pthread_exit((void*)sum);
}

int main()
{
	srand(time(NULL));
	int n = 10,i,j;
	int **matriz;
	matriz = (int **)malloc (n*sizeof(int *));
	for (i=0;i<n;i++)
		matriz[i] = (int *) malloc (n*sizeof(int)); // MATRIZ [n][n]

	for(i=0;i<n;i++)
	{
		matriz[i][0] = n-1;
		printf("arreglo %d: ",i);
		for(j=1;j<n;j++){
			matriz[i][j] = rand()%50; // poner un random
			printf("%d ",matriz[i][j]);
		}
		printf("\n");
	}

	pthread_t sum_thread[n];
	for(i=0;i<n;i++){
		if(pthread_create(&sum_thread[i], NULL, sum_arreglo_func, matriz[i])){
			fprintf(stderr, "Error creando alguna hebra.\n");
			return 1;
		}

	}

	int sum[n];
	for(i=0;i<n;i++){
		if( pthread_join(sum_thread[i],  (void**)&sum[i]) ){
			fprintf(stderr, "Error joining thread\n");
			return 2;
		}

	}
	for(i=0;i<n;i++){
		printf("arreglo %d, suma: %d\n",i,sum[i]);
	}

	return 0;

}
